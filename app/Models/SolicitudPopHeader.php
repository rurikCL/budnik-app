<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudPopHeader extends Model
{
    protected $table = 'POP10200';
    protected $primaryKey = 'POPRequisitionNumber';
    protected $connection = 'budnik';

    protected $fillable = [
        'POPRequisitionNumber',
        'Requisition_Note_Index',
        'RequisitionDescription',
        'RequisitionStatus',
        'COMMNTID',
        'Comment_Note_Index',
        'DOCDATE',
        'REQDATE',
        'REQSTDBY',
        'PRSTADCD',
        'CMPNYNAM',
        'CONTACT',
        'ADDRESS1',
        'ADDRESS2',
        'ADDRESS3',
        'CITY',
        'STATE',
        'ZIPCODE',
        'CCode',
        'COUNTRY',
        'PHONE1',
        'PHONE2',
        'PHONE3',
        'FAX',
        'DOCAMNT',
        'CREATDDT',
        'MODIFDT',
        'USER2ENT',
        'Flags',
        'Workflow_Status',
        'DomainUserName',
        'USERDEF1',
        'USERDEF2',
        'DEX_ROW_TS',
        'DEX_ROW_ID',
    ];
}
