<?php

class Service implements JsonSerializable {
    //Mis propiedades
    private $id;
    private $name;
    private $description;
    private $price;
    private $category;
    private $quantity;

    //Constructor de la clase
    public function __construct($id, $name, $description, $price, $category){
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
        $this->quantity = 1;
    }

    public function getId(){ return $this->id; }
    public function getName(){ return $this->name; }
    public function getDescription(){ return $this->description; }
    public function getPrice(){ return $this->price; }
    public function getCategory(){ return $this->category; }
    public function getQuantity(){ return $this->quantity; }
    public function setQuantity($quantity){$this->quantity = $quantity; }
    public function getSubtotal(){ return $this->price * $this->quantity; }


    //Función para encontrar el servicio y devolver una intancia
    public static function findById($id){
        //Encuentro el JSON
        $json = __DIR__ . '/../assets/services.json';
        //Saco la info del JSON y la convierto en texto plano
        $jsonData = file_get_contents($json);
        //Convierto mi texto plano en un arreglo asociativo
        $services = json_decode($jsonData,true);

        //Foreach en la info
        foreach($services as $service){
            //Si tienen el mismo id
            if ($service['id'] == $id){
                //Devuelve una instancia de Service
                return new self(
                    $service['id'],
                    $service['nombre'],
                    $service['descripcion'],
                    $service['precio_base'],
                    $service['categoria']
                );
            }
        }
        return null;
    }
    
    public static function getServices(){
        $json = __DIR__ . "/../assets/services.json";

        if (!file_exists($json)) return null;

        $jsonData = file_get_contents($json);
        $services = json_decode($jsonData,true);

        return $services;
    }

    //Para pasar los datos con json_encode()
    public function jsonSerialize() {
        return [
            'id'          => $this->getId(),
            'name'        => $this->getName(),        // Podemos usar el getter
            'description' => $this->getDescription(),     // O la propiedad directo (aquí sí se puede)
            'price'       => $this->getPrice(),
            'category'    => $this->getCategory(),
            'quantity'    => $this->getQuantity(),
            'subtotal'    => $this->getSubtotal()    // ¡Incluso podemos enviar datos calculados!
        ];
    }
}