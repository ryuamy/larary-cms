<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
// use App\Models\UserProfile;

class ProfileRequest extends FormRequest
{
    // /**
    //  * Determine if the user is authorized to make this request.
    //  *
    //  * @return bool
    //  */
    // public function authorize()
    // {
    //     return true;
    // }

    // /**
    //  * Get the validation rules that apply to the request.
    //  *
    //  * @return array
    //  */
    // public function rules()
    // {
    //     $user_profile = UserProfile::where("user_id", Auth::user()->id)->first();
        
    //     return [
    //         "nik" => "required|unique:user_profile,nik,".$user_profile["id"]."|numeric",
    //         "name" => "required|alpha_spaces",
    //         "education" => "required|numeric",
    //         "citizenship" => "required|numeric",
    //         "gender" => "required|numeric",
    //         "phone" => "required|idn_phone_number",
    //         "job" => "required|alpha_num_spaces",
    //         "birthdate" => "required|date",
    //         "email" => "nullable|email",
    //         "address" => "required|alpha_num_spaces",
    //     ];
    // }

    // /**
    //  * Custom message for validation
    //  *
    //  * @return array
    //  */
    // public function messages()
    // {
    //     return [
    //         "nik.required" => "NIK KTP / SIM / No Passport tidak boleh kosong.",
    //         "nik.unique" => "NIK KTP / SIM / No Passport sudah terdaftar.",
    //         "nik.numeric" => "NIK KTP / SIM / No Passport hanya boleh diisi dengan angka.",
    //         "name.required" => "Nama tidak boleh kosong.",
    //         "name.alpha_spaces" => "Nama hanya boleh diisi dengan alpha dan space.",
    //         "education.required" => "Pendidikan wajib dipilih.",
    //         "citizenship.required" => "Jenis kelamin wajib dipilih.",
    //         "gender.required" => "Kewarganegaraan wajib dipilih.",
    //         "phone.required" => "No. Telp / No. HP tidak boleh kosong.",
    //         "phone.idn_phone_number" => "Format no. telp / no. HP hanya boleh diisi dengan angka dan diawali dengan '+62' atau '0'",
    //         "job.required" => "Pekerjaan tidak boleh kosong.",
    //         "job.alpha_num_spaces" => "Pekerjaan hanya boleh diisi dengan alfabet, angka dan space.",
    //         "birthdate.required" => "Tanggal lahir tidak boleh kosong.",
    //         "birthdate.date" => "Format tanggal lahir salah.",
    //         "email.email" => "Format email salah.",
    //         "address.required" => "Alamat tidak boleh kosong.",
    //     ];
    // }
}
