<?php
class Quote {
    private $codigo;
    private $cliente;
    private $items;
    private $subtotal;
    private $descuento;
    private $impuesto;
    private $total;
    private $fecha;
    private $fechaVencimiento;

    public function __construct($datosCliente, $itemsCarrito) {
        $this->codigo = self::generarCodigo();
        $this->cliente = $datosCliente; // Arreglo con nombre, empresa, correo
        $this->items = $itemsCarrito;
        $this->fecha = date('Y-m-d');
        $this->fechaVencimiento = date('Y-m-d', strtotime('+7 days'));
        $this->calcularTotales();
    }

    private function calcularTotales() {
        $this->subtotal = 0;
        foreach ($this->items as $item) {
            $this->subtotal += $item->getSubtotal();
        }

        $porcentaje = 0;
        if ($this->subtotal >= 2500) {
            $porcentaje = 0.15;
        } elseif ($this->subtotal >= 1000) {
            $porcentaje = 0.10;
        } elseif ($this->subtotal >= 500) {
            $porcentaje = 0.05;
        }

        $this->descuento = $this->subtotal * $porcentaje;
        $this->impuesto = ($this->subtotal - $this->descuento) * 0.13;
        $this->total = $this->subtotal - $this->descuento + $this->impuesto;
    }

    public static function generarCodigo() {
        if (!isset($_SESSION['contador_cotizacion'])) {
            $_SESSION['contador_cotizacion'] = 1;
        }
        $anio = date('Y');
        $correlativo = str_pad($_SESSION['contador_cotizacion']++, 4, '0', STR_PAD_LEFT);
        return "COT-{$anio}-{$correlativo}";
    }

    // Getters 
    public function getCodigo() { return $this->codigo; }
    public function getCliente() { return $this->cliente; }
    public function getItems() { return $this->items; }
    public function getSubtotal() { return $this->subtotal; }
    public function getDescuento() { return $this->descuento; }
    public function getImpuesto() { return $this->impuesto; }
    public function getTotal() { return $this->total; }
    public function getFecha() { return $this->fecha; }
    public function getFechaVencimiento() { return $this->fechaVencimiento; }
}