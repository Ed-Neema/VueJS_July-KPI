<?php

namespace App\Actions\Jetstream;

use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     *
     * @param  mixed  $user
     *
     * @return void
     */
    public function delete($user)
    {
        $user->deleteProfilePhoto();

        $user->company->submissions->each(function ($values) {
            $values->values()->delete();
        });
        $user->company->submissions()->delete();

        $user->company->forms->each(function ($form) {
            $form->enquiryFields()->detach();
        });

        $user->company->forms()->delete();
        $user->company->fields()->delete();
        $user->company->sources()->delete();
        $user->company()->delete();

        $user->tokens->each->delete();
        $user->delete();
    }
}
