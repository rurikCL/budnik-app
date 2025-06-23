<?php

namespace App\Http\Controllers;

use App\Models\Item_tax;
use App\Models\solicitudes_compra;
use App\Models\SolicitudPop;
use App\Models\SolicitudPopHeader;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrdenCompraController extends Controller
{
    public function aprobarSolicitud($solicitudID)
    {
        //TODO: Implementar la lógica para aprobar una solicitud de compra
        $solicitudPop = SolicitudPopHeader::where('POPRequisitionNumber', $solicitudID)->first();
        $this->revisaItemsSolicitud($solicitudPop);
    }

    public function rechazarSolicitud(Request $request)
    {
        //TODO: Implementar la lógica para rechazar una solicitud de compra
    }

    public function crearOrdenCompra(Request $request)
    {
        //TODO: Implementar la lógica para crear una orden de compra


    }

    public function revisaItemsSolicitud(SolicitudPopHeader $solicitud)
    {

        $idSolExterna = $solicitud->POPRequisitionNumber;
        $items = SolicitudPop::where('POPRequisitionNumber', $idSolExterna)->get();

        $DBObj = DB::connection('budnik');
        $DBObj->beginTransaction();
        try {
            foreach ($items as $item) {
                // Aquí puedes agregar la lógica para revisar cada ítem de la solicitud
                // Por ejemplo, verificar si el ítem está disponible, etc.
                $ITMNMBR = $item->ITEMNMBR;
                $VENDORID = $item->VENDORID;
                $LINENMBR = $item->LineNumber;

                $itemTax = Item_tax::where('ITEMNMBR', $ITMNMBR)
                    ->where('VENDORID', $VENDORID)
                    ->count();
                Log::info($ITMNMBR ." tiene tax : " . $itemTax);

                if ($itemTax == 0) {
                    $DBObj->statement("
                INSERT INTO IV00103
                (ITEMNMBR, VENDORID, ITMVNDTY, VNDITNUM, QTYRQSTN, QTYONORD, QTY_Drop_Shipped, LSTORDDT, LSORDQTY, LRCPTQTY, LSRCPTDT, LRCPTCST,
                AVRGLDTM, NORCTITM, MINORQTY, MAXORDQTY, ECORDQTY, VNDITDSC, Last_Originating_Cost, Last_Currency_ID, FREEONBOARD, PRCHSUOM,
                CURRNIDX, PLANNINGLEADTIME, ORDERMULTIPLE, MNFCTRITMNMBR)
                SELECT IV.ITEMNMBR, PM.VENDORID, IV.ITEMTYPE, SUBSTRING(IV.ITEMDESC, 1, 30), 0, 0, 0, '01-01-01', 0, 0, '01-01-01', 0, 0, 0, 0, 0, 0, IV.ITEMDESC, IV.STNDCOST,
                PM.CURNCYID, 1, '', 7 AS CURRNIDX, 0, 1, ''
                FROM IV00101 IV, PM00200 PM
                WHERE IV.ITEMNMBR = '$ITMNMBR' AND PM.VENDORID = '$VENDORID'
                ");

                }

                // taCreateItemVendors
                $itemVendor = $DBObj->select("execute PortalItemVendor '$ITMNMBR', '$VENDORID' ,'$VENDORID'");


                $fecha = Carbon::now()->format('Y-m-d');
                $PONUMBER = $DBObj->select('select dbo.POPRequisitionNumber from Pop40100')[0]->POPRequisitionNumber;
                dump($PONUMBER);

                $LOCNCODE =  $item->LOCNCODE;
                $QUANTITY = $item->QTYORDER;
                $QTYCANCELED = 0;//$item->QTYCANCELED;
                $COMMENT = $item->Comment_Note_Index;
                $UNITCOST = $item->UNITCOST;
                $UOFM = $item->UOFM;
                $ORD = $item->ORD;
                $cod = '';
                $msg = '';

                $linea = $DBObj->select(
                    "
                    declare @O_iErrorState int, @oErrString varchar(30)

EXECUTE [dbo].[taPoLine]
   1
  ,'$PONUMBER'
  ,'$fecha'
  ,'$VENDORID'
  ,'$LOCNCODE'
  ,$LINENMBR
  ,'$ITMNMBR '
  ,$QUANTITY
  ,$QTYCANCELED
  ,default
  ,'sa'
  ,default
  ,default
  ,default
  ,default
  ,default
  ,'2024-11-14 00:00:00.000'
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,'Pruba OC'
  ,$UNITCOST
  ,default
  ,'$UOFM'
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default

  ,1
  ,default
  ,''
  ,default
  ,default
  ,default
  ,default
  ,default
  ,default
  ,@O_iErrorState OUTPUT
  ,@oErrString OUTPUT



  SELECT @O_iErrorState = ERRORDESC FROM DYNAMICS..taErrorCode WHERE ERRORCODE = @oErrString
SELECT @oErrString AS CodError, @O_iErrorState AS ErrorDesc
"
                );
                dump($linea);


            }
            $DBObj->commit();

        } catch (\Exception $e) {
            $DBObj->rollBack();
            throw $e; // O maneja el error de otra manera
        }

    }
}
