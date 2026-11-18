<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

/** Buat booking contoh untuk tes, tidak menyentuh data asli demo. */
function sampleGuestBooking(User $user, string $code, string $status = 'unpaid', bool $insurance = true, int $days = 8): void
{
    $roomId = DB::table('rooms')->insertGetId(['name'=>'Test Dome','category'=>'Dome','description'=>'Test','price_per_night'=>400000,'total_stock'=>2,'created_at'=>now(),'updated_at'=>now()]);
    DB::table('bookings')->insert(['booking_code'=>$code,'user_id'=>$user->id,'room_id'=>$roomId,'guest_name'=>'Tester','guest_email'=>$user->email,'guest_phone'=>'08123456789','check_in_date'=>now('Asia/Jakarta')->addDays($days)->toDateString(),'check_out_date'=>now('Asia/Jakarta')->addDays($days+2)->toDateString(),'duration_nights'=>2,'room_price'=>400000,'has_insurance'=>$insurance,'insurance_fee'=>$insurance ? 25000 : 0,'total_amount'=>$insurance ? 825000 : 800000,'status'=>$status,'created_at'=>now(),'updated_at'=>now()]);
}

test('guest cannot access payment and profile routes', function () {
    $this->get(route('dashboard.payments'))->assertRedirect(route('login'));
    $this->get(route('dashboard.profile'))->assertRedirect(route('login'));
});

test('sandbox payment confirms only owned unpaid booking', function () {
    $owner=User::factory()->create(); $other=User::factory()->create();
    sampleGuestBooking($owner,'GLAMP-PAY-01');
    $this->actingAs($other)->post(route('dashboard.bookings.pay','GLAMP-PAY-01'))->assertNotFound();
    $this->actingAs($owner)->post(route('dashboard.bookings.pay','GLAMP-PAY-01'))->assertRedirect();
    expect(DB::table('bookings')->where('booking_code','GLAMP-PAY-01')->value('status'))->toBe('confirmed');
    $this->actingAs($owner)->post(route('dashboard.bookings.pay','GLAMP-PAY-01'))->assertSessionHasErrors('payment');
});

test('unpaid booking may be cancelled without staff', function () {
    $owner=User::factory()->create();sampleGuestBooking($owner,'GLAMP-DISCARD');
    $this->actingAs($owner)->post(route('dashboard.bookings.discard','GLAMP-DISCARD'))->assertRedirect();
    expect(DB::table('bookings')->where('booking_code','GLAMP-DISCARD')->value('status'))->toBe('cancelled');
});

test('cancellation with insurance more than three days returns room subtotal only', function () {
    $owner=User::factory()->create();sampleGuestBooking($owner,'GLAMP-CANCEL-01','confirmed',true,8);
    $this->actingAs($owner)->post(route('dashboard.bookings.cancellation','GLAMP-CANCEL-01'),['reason'=>'Perjalanan keluarga berubah mendadak'])->assertRedirect();
    $row=DB::table('cancellation_requests')->first();
    expect($row->status)->toBe('pending')->and((int)$row->refund_percentage)->toBe(100)->and((float)$row->refund_amount)->toBe(800000.0);
    expect(DB::table('bookings')->where('booking_code','GLAMP-CANCEL-01')->value('status'))->toBe('confirmed');
});

test('cancellation within three days refunds 50 percent and no insurance refunds zero', function () {
    $user=User::factory()->create();sampleGuestBooking($user,'GLAMP-50','confirmed',true,2);sampleGuestBooking($user,'GLAMP-0','confirmed',false,8);
    $this->actingAs($user)->post(route('dashboard.bookings.cancellation','GLAMP-50'),['reason'=>'Tidak bisa datang karena jadwal berubah']);
    $this->actingAs($user)->post(route('dashboard.bookings.cancellation','GLAMP-0'),['reason'=>'Tidak bisa datang karena jadwal berubah']);
    expect((int)DB::table('cancellation_requests')->where('booking_id',DB::table('bookings')->where('booking_code','GLAMP-50')->value('id'))->value('refund_percentage'))->toBe(50);
    expect((float)DB::table('cancellation_requests')->where('booking_id',DB::table('bookings')->where('booking_code','GLAMP-0')->value('id'))->value('refund_amount'))->toBe(0.0);
});

test('duplicate pending cancellation is rejected', function () {
    $user=User::factory()->create();sampleGuestBooking($user,'GLAMP-ONCE','confirmed');
    $this->actingAs($user)->post(route('dashboard.bookings.cancellation','GLAMP-ONCE'),['reason'=>'Perjalanan keluarga berubah mendadak'])->assertRedirect();
    $this->actingAs($user)->post(route('dashboard.bookings.cancellation','GLAMP-ONCE'),['reason'=>'Perjalanan keluarga berubah mendadak'])->assertSessionHasErrors('reason');
    expect(DB::table('cancellation_requests')->count())->toBe(1);
});

test('profile update cannot elevate role and password is hashed', function () {
    $user=User::factory()->create(['role'=>'user','password'=>Hash::make('OriginalPass#1')]);
    $this->actingAs($user)->patch(route('dashboard.profile.update'),['name'=>'Tamu Baru','email'=>'tamu.baru@example.test','phone'=>'08123456789','role'=>'admin'])->assertRedirect();
    $user->refresh();expect($user->role)->toBe('user')->and($user->name)->toBe('Tamu Baru');
    $this->actingAs($user)->patch(route('dashboard.profile.password'),['current_password'=>'OriginalPass#1','password'=>'AnotherPass#2','password_confirmation'=>'AnotherPass#2'])->assertRedirect();
    expect(Hash::check('AnotherPass#2',$user->fresh()->password))->toBeTrue();
});
