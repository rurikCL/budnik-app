<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item_tax extends Model
{
    protected $table = 'dbo.IV00103';
    protected $primaryKey = 'ITEMNMBR';
    protected $connection = 'budnik';

    protected $fillable = [
        'ITEMNMBR',
        'VENDORID',
        'ITMVNDTY',
        'VNDITNUM',
        'QTYRQSTN',
        'QTYONORD',
        'QTY_Drop_Shipped',
        'LSTORDDT',
        'LSORDQTY',
        'LRCPTQTY',
        'LSRCPTDT',
        'LRCPTCST',
        'AVRGLDTM',
        'NORCTITM',
        'MINORQTY',
        'MAXORDQTY',
        'ECORDQTY',
        'VNDITDSC',
        'Last_Originating_Cost',
        'Last_Currency_ID',
        'FREEONBOARD',
        'PRCHSUOM',
        'CURRNIDX',
        'PLANNINGLEADTIME',
        'ORDERMULTIPLE',
        'MNFCTRITMNMBR',
        'DEX_ROW_ID'
    ];
}

/*SELECT TOP (1000)
[ITEMNMBR]
      ,[VENDORID]
      ,[ITMVNDTY]
      ,[VNDITNUM]
      ,[QTYRQSTN]
      ,[QTYONORD]
      ,[QTY_Drop_Shipped]
      ,[LSTORDDT]
      ,[LSORDQTY]
      ,[LRCPTQTY]
      ,[LSRCPTDT]
      ,[LRCPTCST]
      ,[AVRGLDTM]
      ,[NORCTITM]
      ,[MINORQTY]
      ,[MAXORDQTY]
      ,[ECORDQTY]
      ,[VNDITDSC]
      ,[Last_Originating_Cost]
      ,[Last_Currency_ID]
      ,[FREEONBOARD]
      ,[PRCHSUOM]
      ,[CURRNIDX]
      ,[PLANNINGLEADTIME]
      ,[ORDERMULTIPLE]
      ,[MNFCTRITMNMBR]
      ,[DEX_ROW_ID]
*/
