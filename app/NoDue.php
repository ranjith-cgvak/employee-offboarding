<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoDue extends Model
{
    protected $fillable = [
        'resignation_id',
        'knowledge_transfer_lead',
        'knowledge_transfer_lead_comment',
        'mail_id_closure_lead',
        'mail_id_closure_lead_comment',
        'knowledge_transfer_head',
        'knowledge_transfer_head_comment',
        'mail_id_closure_head',
        'mail_id_closure_head_comment',
        'id_card',
        'id_card_comment',
        'nda',
        'nda_comment',
        'official_email_id',
        'official_email_id_comment',
        'skype_account',
        'skype_account_comment'   
    ];
}
