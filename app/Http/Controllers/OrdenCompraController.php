<?php

namespace App\Http\Controllers;

use App\Models\solicitudes_compra;
use App\Models\SolicitudPop;
use App\Models\SolicitudPopHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenCompraController extends Controller
{
    public function aprobarSolicitud(SolicitudPop $solicitudPop)
    {
        //TODO: Implementar la lógica para aprobar una solicitud de compra
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

                $DBObj->raw("
                DECLARE @ITEMNMBR VARCHAR(30) = '$ITMNMBR', @VENDORID VARCHAR(15) = '$VENDORID'
                SELECT COUNT(1) FROM IV00103 IV WHERE IV.ITEMNMBR = @ITEMNMBR AND IV.VENDORID = @VENDORID
                IF (SELECT COUNT(1) FROM IV00103 IV WHERE IV.ITEMNMBR = @ITEMNMBR AND IV.VENDORID = @VENDORID) = 0

                BEGIN

                INSERT INTO IV00103
                (ITEMNMBR, VENDORID, ITMVNDTY, VNDITNUM, QTYRQSTN, QTYONORD, QTY_Drop_Shipped, LSTORDDT, LSORDQTY, LRCPTQTY, LSRCPTDT, LRCPTCST,
                AVRGLDTM, NORCTITM, MINORQTY, MAXORDQTY, ECORDQTY, VNDITDSC, Last_Originating_Cost, Last_Currency_ID, FREEONBOARD, PRCHSUOM,
                CURRNIDX, PLANNINGLEADTIME, ORDERMULTIPLE, MNFCTRITMNMBR)
                SELECT IV.ITEMNMBR, PM.VENDORID, IV.ITEMTYPE, SUBSTRING(IV.ITEMDESC, 1, 30), 0, 0, 0, '01-01-01', 0, 0, '01-01-01', 0, 0, 0, 0, 0, 0, IV.ITEMDESC, IV.STNDCOST,
                PM.CURNCYID, 1, '', 7 AS CURRNIDX, 0, 1, ''
                FROM IV00101 IV, PM00200 PM
                WHERE IV.ITEMNMBR = @ITEMNMBR AND PM.VENDORID = @VENDORID
                END
                IF (SELECT COUNT(1) FROM IV00101 IV, PM00200 PM WHERE IV.ITEMNMBR = @ITEMNMBR AND PM.VENDORID = @VENDORID) = 0
                SELECT 1 as CodError, 'Id Articulo o Id Proveedor No Existe' as ErrorDesc
                ELSE
                SELECT 0 as CodError, 'Relacion Satisfactoria' as ErrorDesc
                ");
            }
            $DBObj->commit();
        } catch (\Exception $e) {
            $DBObj->rollBack();
            throw $e; // O maneja el error de otra manera
        }

    }
}
