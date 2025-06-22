<?php

namespace App\Services\Interfaces;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;

interface ProfileServiceInterface {
    public function update(ProfileUpdateRequest $request);
    public function destroy(Request $request);
}
