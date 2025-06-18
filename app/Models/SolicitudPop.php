<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudPop extends Model
{

    protected $table = 'dbo.POP10210';
    protected $primaryKey = 'POPRequisitionNumber';
    protected $connection = 'budnik';

    protected $fillable = [
        'POPRequisitionNumber',
        'ORD',
        'RequisitionLineStatus',
        'LineNumber',
        'ITEMNMBR',
        'ITEMDESC',
        'Item_Number_Note_Index',
        'VENDORID',
        'Vendor_Note_Index',
        'NONINVEN',
        'UOFM',
        'UMQTYINB',
        'LOCNCODE',
        'Location_Code_Note_Index',
        'QTYORDER',
        'QTYCMTBASE',
        'QTYUNCMTBASE',
        'UNITCOST',
        'ORUNTCST',
        'EXTDCOST',
        'OREXTCST',
        'REQDATE',
        'REQSTDBY',
        'INVINDX',
        'ACCNTNTINDX',
        'CURNCYID',
        'Currency_Note_Index',
        'CURRNIDX',
        'RATETPID',
        'EXGTBLID',
        'XCHGRATE',
        'EXCHDATE',
        'TIME1',
        'RATECALC',
        'DENXRATE',
        'MCTRXSTT',
        'DECPLCUR',
        'DECPLQTY',
        'ODECPLCU',
        'ITMTRKOP',
        'VCTNMTHD',
        'ADRSCODE',
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
        'Print_Phone_NumberGB',
        'ADDRSOURCE',
        'Flags',
        'SHIPMTHD',
        'ShippingMethodNoteIndex',
        'FRTAMNT',
        'ORFRTAMT',
        'TAXAMNT',
        'ORTAXAMT',
        'InvalidDataFlag',
        'COMMNTID',
        'Comment_Note_Index',
        'USERDEF1',
        'USERDEF2',
        'DEX_ROW_TS',
        'DEX_ROW_ID',
    ];

}
