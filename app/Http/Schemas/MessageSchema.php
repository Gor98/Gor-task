<?php

namespace App\Http\Schemas;

class MessageSchema
{
    private $prefix = 'message';

    public function get()
    {
        return [
            'tele_message_id' => [
                'path' => [
                    $this->prefix.'.message_id',
                ],
            ],
            'tele_chat_id' => [
                'path' => [
                    $this->prefix.'.chat.id',
                ],
            ],
            'message' => [
                'path' => [
                    $this->prefix.'.text',
                ],
            ],
            'sender' => [
                'path' => [
                    $this->prefix.'.from.username',
                ],
            ],
        ];
    }

    private function getRegionAndCommunityJurFromAcra($source)
    {
        $jur_region = $source['acra']['PARTICIPIENT']['TaxServiceInfo']['Response']['OrgJurLocation']['Region'];
        $jur_community = $source['acra']['PARTICIPIENT']['TaxServiceInfo']['Response']['OrgJurLocation']['Community'];

        return [$jur_region, $jur_community];
    }
}
