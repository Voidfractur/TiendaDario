<?php
require_once("Conexion.lib.php");
class Reportes
{
    private $cnn;
    public function __construct()
    {
        $this->cnn = conexion();
    }

    public function getVentasdelDia()
    {
        return $this->cnn->query("SELECT id_tic,fechaventa_tic,total_tic,ticket.cve_cli,cliente.cve_per,nombre_per,ap_per FROM tiendita.ticket inner join cliente on ticket.cve_cli = cliente.id_cli inner join persona on cliente.cve_per = persona.id_per where fechaventa_tic = curdate() order by id_tic asc");
    }
    public function getClientes()
    {
        return $this->cnn->query("SELECT id_cli,nombre_per,ap_per FROM tiendita.cliente inner join persona on cliente.cve_per = persona.id_per");
    }

    public function getBusqueda($fecha1, $fecha2, $cliente, $radio)
    {
        if ($fecha1 == 0 && $fecha2 == 0 && $cliente == 0) {
            return $this->cnn->query("SELECT id_tic,fechaventa_tic,total_tic,ticket.cve_cli,cliente.cve_per,nombre_per,ap_per FROM tiendita.ticket inner join cliente on ticket.cve_cli = cliente.id_cli inner join persona on cliente.cve_per = persona.id_per where (fechaventa_tic BETWEEN curdate() AND curdate()) order by id_tic asc");
        }
        if ($cliente == 0 && $radio == "ambos") {
            return $this->cnn->query("SELECT id_tic,fechaventa_tic,total_tic,ticket.cve_cli,cliente.cve_per,nombre_per,ap_per FROM tiendita.ticket inner join cliente on ticket.cve_cli = cliente.id_cli inner join persona on cliente.cve_per = persona.id_per where (fechaventa_tic BETWEEN '$fecha1' AND '$fecha2') order by id_tic asc");
        }

        if ($cliente == 0 && $radio == "credito") {
            return $this->cnn->query("SELECT id_tic,fechaventa_tic,total_tic,ticket.cve_cli,cliente.cve_per,nombre_per,ap_per FROM tiendita.ticket inner join cliente on ticket.cve_cli = cliente.id_cli inner join persona on cliente.cve_per = persona.id_per where (fechaventa_tic BETWEEN '$fecha1' AND '$fecha2') and exists (select * from credito where ticket.id_tic = credito.cve_tic) order by id_tic asc;");
        }

        if ($cliente == 0 && $radio == "contado") {
            return $this->cnn->query("SELECT id_tic,fechaventa_tic,total_tic,ticket.cve_cli,cliente.cve_per,nombre_per,ap_per FROM tiendita.ticket inner join cliente on ticket.cve_cli = cliente.id_cli inner join persona on cliente.cve_per = persona.id_per where (fechaventa_tic BETWEEN '$fecha1' AND '$fecha2') and not exists (select * from credito where ticket.id_tic = credito.cve_tic) order by id_tic asc");
        }

        if ($cliente != 0 && $radio == "ambos") {
            return $this->cnn->query("SELECT id_tic,fechaventa_tic,total_tic,ticket.cve_cli,cliente.cve_per,nombre_per,ap_per FROM tiendita.ticket inner join cliente on ticket.cve_cli = cliente.id_cli inner join persona on cliente.cve_per = persona.id_per where (fechaventa_tic BETWEEN '$fecha1' AND '$fecha2') and cve_cli=$cliente  order by id_tic asc;");
        }

        if ($cliente != 0 && $radio == "credito") {
            return $this->cnn->query("SELECT id_tic,fechaventa_tic,total_tic,ticket.cve_cli,cliente.cve_per,nombre_per,ap_per FROM tiendita.ticket inner join cliente on ticket.cve_cli = cliente.id_cli inner join persona on cliente.cve_per = persona.id_per where (fechaventa_tic BETWEEN '$fecha1' AND '$fecha2') and cve_cli=$cliente  and exists (select * from credito where ticket.id_tic = credito.cve_tic) order by id_tic asc;");
        }

        if ($cliente != 0 && $radio == "contado") {
            return $this->cnn->query("SELECT id_tic,fechaventa_tic,total_tic,ticket.cve_cli,cliente.cve_per,nombre_per,ap_per FROM tiendita.ticket inner join cliente on ticket.cve_cli = cliente.id_cli inner join persona on cliente.cve_per = persona.id_per where (fechaventa_tic BETWEEN '$fecha1' AND '$fecha2') and cve_cli=$cliente  and not exists (select * from credito where ticket.id_tic = credito.cve_tic) order by id_tic asc;");
        }
    }

    public function getDetallesTicket($cve_tic)
    {
        return $this->cnn->query("select codigo_pro,nombre_pro,cantidad_ren,precio_pro,(cantidad_ren * precio_pro) as importe from renglonticket inner join producto on renglonticket.cve_pro=producto.id_pro where cve_tic=$cve_tic");
    }
}
