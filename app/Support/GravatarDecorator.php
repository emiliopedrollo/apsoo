<?php


namespace App\Support;

use App\Models\User;
use \Pedrollo\GravatarLib\Gravatar;

class GravatarDecorator extends Gravatar
{
    const DEFAULT_IMAGE_404 = '404';
    const DEFAULT_IMAGE_MM = 'mm';
    const DEFAULT_IMAGE_IDENT_ICON = 'identicon';
    const DEFAULT_IMAGE_MONSTER_ID = 'monsterid';
    const DEFAULT_IMAGE_WAVATAR = 'wavatar';
    const DEFAULT_IMAGE_RETRO = 'retro';


    public function __construct()
    {
        $this->enableSecureImages();
    }

    public function get($email, $hash_email = true)
    {
        return parent::get($email, gettype($email) === 'string' ? $hash_email : false);
    }

    public function getUserAvatar(User $user, $default = self::DEFAULT_IMAGE_WAVATAR): string
    {
        return $this->setDefaultImage($default)
            ->get($user->enable_gravatar ? $user->email : $user->id);
    }

}
