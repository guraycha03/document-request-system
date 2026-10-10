<?php

namespace Tests\Feature;

use App\Models\DocumentRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocumentRequestAccessTest extends TestCase
{
    use RefreshDatabase;

    private function makeStudent(string $name, string $email): User
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => 'student123',
            'role' => User::ROLE_STUDENT,
        ]);
    }

    private function makeAdministrator(): User
    {
        return User::create([
            'name' => 'Mike Santos',
            'email' => 'mike.s@gmail.com',
            'password' => 'admin123',
            'role' => User::ROLE_ADMINISTRATOR,
        ]);
    }

    private function makeRequestFor(User $owner, string $item = 'Transcript of Records'): DocumentRequest
    {
        $request = new DocumentRequest();
        $request->item_name = $item;
        $request->quantity = 1;
        $request->purpose = 'Official purposes';
        $request->user_id = $owner->id;
        $request->requester_name = $owner->name;
        $request->requester_email = $owner->email;
        $request->status = 'pending';
        $request->save();

        return $request;
    }

    public function test_t01_guest_is_redirected_and_sees_no_request_data(): void
    {
        $student = $this->makeStudent('Jane Lim', 'jane.lim@school.edu');
        $this->makeRequestFor($student, 'Transcript of Records');

        $this->get('/')->assertRedirect('/login');
        $this->get('/document-requests/1')->assertRedirect('/login');
    }

    public function test_t02_student_sees_only_own_records(): void
    {
        $studentA = $this->makeStudent('Jane Lim', 'jane.lim@school.edu');
        $studentB = $this->makeStudent('Alon Cruz', 'alon.cruz@school.edu');
        $this->makeRequestFor($studentA, 'Jane Document A');
        $this->makeRequestFor($studentB, 'Alon Document B');

        $this->actingAs($studentA)
            ->get('/')
            ->assertOk()
            ->assertSee('Jane Document A')
            ->assertDontSee('Alon Document B');

        $this->actingAs($studentB)
            ->get('/')
            ->assertOk()
            ->assertSee('Alon Document B')
            ->assertDontSee('Jane Document A');
    }

    public function test_t03_student_cannot_open_other_students_record(): void
    {
        $studentA = $this->makeStudent('Jane Lim', 'jane.lim@school.edu');
        $studentB = $this->makeStudent('Alon Cruz', 'alon.cruz@school.edu');
        $own = $this->makeRequestFor($studentA, 'Jane Document A');
        $other = $this->makeRequestFor($studentB, 'Alon Document B');

        $this->actingAs($studentA)
            ->get('/document-requests/'.$own->id)
            ->assertOk()
            ->assertSee('Jane Document A');

        $this->actingAs($studentA)
            ->get('/document-requests/'.$other->id)
            ->assertForbidden()
            ->assertDontSee('Alon Document B');
    }

    public function test_t04_student_status_patch_is_denied_and_status_unchanged(): void
    {
        $studentA = $this->makeStudent('Jane Lim', 'jane.lim@school.edu');
        $studentB = $this->makeStudent('Alon Cruz', 'alon.cruz@school.edu');
        $own = $this->makeRequestFor($studentA);
        $other = $this->makeRequestFor($studentB);

        $this->actingAs($studentA)
            ->patch('/document-requests/'.$other->id, ['status' => 'approved'])
            ->assertForbidden();

        $this->assertSame('pending', $other->fresh()->status);

        $this->actingAs($studentA)
            ->patch('/document-requests/'.$own->id, ['status' => 'approved'])
            ->assertForbidden();

        $this->assertSame('pending', $own->fresh()->status);
    }

    public function test_t05_administrator_lists_views_and_updates_all_requests(): void
    {
        $studentA = $this->makeStudent('Jane Lim', 'jane.lim@school.edu');
        $studentB = $this->makeStudent('Alon Cruz', 'alon.cruz@school.edu');
        $this->makeRequestFor($studentA, 'Jane Document A');
        $other = $this->makeRequestFor($studentB, 'Alon Document B');
        $admin = $this->makeAdministrator();

        $this->actingAs($admin)
            ->get('/')
            ->assertOk()
            ->assertSee('Jane Document A')
            ->assertSee('Alon Document B');

        $this->actingAs($admin)
            ->get('/document-requests/'.$other->id)
            ->assertOk()
            ->assertSee('Alon Document B');

        $this->actingAs($admin)
            ->patch('/document-requests/'.$other->id, ['status' => 'approved'])
            ->assertRedirect(route('dashboard'));

        $this->assertSame('approved', $other->fresh()->status);
    }

    public function test_t06_invalid_quantity_and_blank_item_name_are_rejected(): void
    {
        $student = $this->makeStudent('Jane Lim', 'jane.lim@school.edu');

        foreach ([0, -1, 'abc'] as $badQuantity) {
            $this->actingAs($student)
                ->from('/')
                ->post('/document-requests', [
                    'item_name' => 'Transcript of Records',
                    'quantity' => $badQuantity,
                    'purpose' => 'Official purposes',
                ])
                ->assertRedirect('/')
                ->assertSessionHasErrors('quantity');
        }

        $this->actingAs($student)
            ->from('/')
            ->post('/document-requests', [
                'item_name' => '',
                'quantity' => 1,
                'purpose' => 'Official purposes',
            ])
            ->assertRedirect('/')
            ->assertSessionHasErrors('item_name');

        $this->assertSame(0, DocumentRequest::count());
    }

    public function test_t07_spoofed_trusted_fields_are_ignored(): void
    {
        $student = $this->makeStudent('Jane Lim', 'jane.lim@school.edu');
        $administrator = $this->makeAdministrator();

        $this->actingAs($student)->post('/document-requests', [
            'item_name' => 'Barangay Clearance',
            'quantity' => 2,
            'purpose' => 'Official purposes',
            'user_id' => $administrator->id,
            'requester_name' => 'Hacker Name',
            'requester_email' => 'hacker@example.com',
            'status' => 'approved',
            'is_admin' => 1,
            'role' => User::ROLE_ADMINISTRATOR,
        ])->assertRedirect(route('dashboard'));

        $created = DocumentRequest::sole();

        $this->assertSame($student->id, $created->user_id);
        $this->assertSame('Jane Lim', $created->requester_name);
        $this->assertSame('jane.lim@school.edu', $created->requester_email);
        $this->assertSame('pending', $created->status);
        $this->assertSame(User::ROLE_STUDENT, $student->fresh()->role);
    }

    public function test_t08_markup_in_purpose_is_escaped_on_the_detail_page(): void
    {
        $student = $this->makeStudent('Jane Lim', 'jane.lim@school.edu');
        $record = $this->makeRequestFor($student);
        $record->purpose = "For <b>LAB3</b> O'Brien submission";
        $record->save();

        $this->actingAs($student)
            ->get('/document-requests/'.$record->id)
            ->assertOk()
            ->assertDontSee('<b>LAB3</b>', false)
            ->assertSee('For &lt;b&gt;LAB3&lt;/b&gt; O&#039;Brien submission', false);
    }

    public function test_t10_administrator_invalid_status_is_rejected(): void
    {
        $student = $this->makeStudent('Jane Lim', 'jane.lim@school.edu');
        $record = $this->makeRequestFor($student);
        $administrator = $this->makeAdministrator();

        $this->actingAs($administrator)
            ->from('/')
            ->patch('/document-requests/'.$record->id, ['status' => 'banana'])
            ->assertRedirect('/')
            ->assertSessionHasErrors('status');

        $this->assertSame('pending', $record->fresh()->status);
    }
}
