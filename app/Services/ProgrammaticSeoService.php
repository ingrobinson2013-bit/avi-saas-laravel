<?php

namespace App\Services;

class ProgrammaticSeoService
{
    /**
     * Problemas clínicos de piel y digestión (basados en búsquedas reales de Google Search Console)
     */
    public static function getSymptoms(): array
    {
        return [
            'lamido-de-patas' => [
                'slug' => 'lamido-de-patas',
                'short' => 'Lamido de Patas y Patas Rojas',
                'title_prefix' => 'Perro que se Lame Mucho las Patas y las Tiene Rojas',
                'keyword' => 'lamido de patas y pododermatitis',
                'meta_hook' => 'Por qué se lame compulsivamente las patas, cómo frenar la pododermatitis por levaduras y qué suplemento hipoalergénico darle en Colombia.',
                'root_cause' => 'En más del 80% de los casos, el lamido compulsivo de patas y el enrojecimiento interdigital (pododermatitis) se deben a alergia a proteínas comunes como el pollo o los cereales del concentrado, sumado a sobrecrecimiento de levaduras (Malassezia) por humedad en los pliegues.',
                'signs' => [
                    'Lame o muerde las patas especialmente en la noche o después de comer.',
                    'Piel rosada, roja o café oxidado entre los dedos y almohadillas.',
                    'Mal olor característico (similar a levadura o queso) en las patitas.',
                    'Inflamación o pequeñas costras en los espacios interdigitales.',
                ],
                'protocol' => [
                    'Seca muy bien los espacios entre los dedos después de cada paseo o lluvia.',
                    'Reduce premios o snacks con pollo, res o colorantes artificiales.',
                    'Aporta diariamente Ácido Láurico Dermo-Activo + Prebióticos Gut-Care® mezclados con un poquito de agua en su comida para atacar el origen inmuno-digestivo.',
                ],
            ],
            'alergia-al-pollo' => [
                'slug' => 'alergia-al-pollo',
                'short' => 'Alergia al Pollo y Proteínas Comunes',
                'title_prefix' => 'Alergia al Pollo',
                'keyword' => 'alergia al pollo y dermatitis alimentaria',
                'meta_hook' => 'Síntomas de alergia al pollo en la piel y estómago, qué darle de comer y cómo reforzar su barrera cutánea con proteína novel hipoalergénica.',
                'root_cause' => 'La proteína de pollo es el alérgeno alimentario #1 en perros y gatos en Colombia porque está presente incluso en concentrados de "cordero" o "salmón" como harina de subproductos. Esto dispara histamina en piel, oídos e intestino.',
                'signs' => [
                    'Rascado constante en axilas, barriga, orejas y base de la cola.',
                    'Otitis recurrente con cera oscura o sacudidas frecuentes de cabeza.',
                    'Gases fuertes, ruidos estomacales o heces blandas intermitentes.',
                    'Enrojecimiento abdominal o granitos rojos después de comer.',
                ],
                'protocol' => [
                    'Revisa la etiqueta del concentrado y evita premios con harina de pollo o maíz.',
                    'Restaura la permeabilidad intestinal con prebióticos para frenar la respuesta alérgica.',
                    'Suplementa con Matriz de Micro-Proteína Novel 0% pollo + Omega 3-6-9 en polvo mezclado con un poquito de agua para máxima absorción.',
                ],
            ],
            'caida-de-pelo-y-caspa' => [
                'slug' => 'caida-de-pelo-y-caspa',
                'short' => 'Caída de Pelo Excesiva y Caspa',
                'title_prefix' => 'Caída de Pelo Excesiva, Caspa y Pelaje Opaco',
                'keyword' => 'caída de pelo excesiva y caspa',
                'meta_hook' => 'Cómo frenar la caída de pelo, eliminar la caspa seca y recuperar un manto grueso y brillante en 30 días sin corticoides.',
                'root_cause' => 'La caída excesiva fuera de muda, la seborrea seca (caspa) y las zonas calvas suelen originarse en déficit de ácidos grasos esenciales Omega 3-6-9 biodisponibles, estrés oxidativo del folículo piloso o mala absorción intestinal de nutrientes.',
                'signs' => [
                    'Deja mechones de pelo por toda la casa, ropa y muebles todo el año.',
                    'Escamas blancas (caspa) visibles sobre el lomo o la base de la cola.',
                    'Pelo seco, áspero, quebradizo y sin brillo natural.',
                    'Zonas con menos densidad de pelaje o parches alopécicos.',
                ],
                'protocol' => [
                    'Cepilla 3 veces por semana para estimular la microcirculación del folículo.',
                    'Evita baños excesivos (máximo cada 20-30 días con champú suave).',
                    'Aporta Omega 3-6-9 + aminoácidos bio-activos + prebióticos diariamente durante 30 a 60 días continuos.',
                ],
            ],
            'picazon-y-dermatitis' => [
                'slug' => 'picazon-y-dermatitis',
                'short' => 'Picazón Constante y Dermatitis Atópica',
                'title_prefix' => 'Picazón Constante y Dermatitis en la Piel',
                'keyword' => 'picazón y dermatitis atópica',
                'meta_hook' => 'Alivio natural para la picazón intensa, piel enrojecida y brotes de dermatitis sin depender de corticoides ni inyecciones mensuales.',
                'root_cause' => 'Cuando la barrera lipídica de la piel está debilitada y el 70% del sistema inmune (que vive en el intestino) está inflamado, cualquier ácaro, polen o proteína común desencadena brotes severos de rasquiña y dermatitis.',
                'signs' => [
                    'Se rasca hasta hacerse heridas, costras o zonas húmedas (parches calientes).',
                    'Se frota la cara contra el sofá, alfombras o camas.',
                    'Piel oscura, gruesa o con granitos rojos en abdomen e ingle.',
                    'Recaídas cada vez que termina el efecto de corticoides o pastillas.',
                ],
                'protocol' => [
                    'Refuerza la barrera lipídica desde adentro con Ácido Láurico y Omega 3-6-9.',
                    'Modula el sistema inmune intestinal (eje intestino-piel) con prebióticos diarios.',
                    'Mezcla la dosis de polvo bio-activo con un poquito de agua tibia sobre su alimento para que lo acepte 100% garantizado.',
                ],
            ],
            'heces-blandas-y-gastritis' => [
                'slug' => 'heces-blandas-y-gastritis',
                'short' => 'Heces Blandas, Gases y Estómago Sensible',
                'title_prefix' => 'Heces Blandas, Gases y Estómago Sensible',
                'keyword' => 'heces blandas, gases y estómago sensible',
                'meta_hook' => 'Cómo firmar las heces en 7-14 días, reducir el mal olor y equilibrar la flora intestinal con prebióticos clínicos Gut-Care®.',
                'root_cause' => 'El estrés, los cambios de concentrado, los antibióticos y los cereales inflamatorios destruyen la microbiota benéfica, causando disbiosis, fermentación excesiva (gases), mucosidad y heces blandas recurrentes.',
                'signs' => [
                    'Heces blandas, pastosas o difíciles de recoger en el parque.',
                    'Flatulencias con olor muy fuerte o ruidos en la barriga.',
                    'Inapetencia matutina o vómitos esporádicos de bilis amarilla.',
                    'Pelo opaco por baja absorción de vitaminas y minerales.',
                ],
                'protocol' => [
                    'Mantén horarios fijos de alimentación y evita sobras de comida humana.',
                    'Si cambias de alimento, haz transición gradual durante 7 a 10 días.',
                    'Incorpora prebióticos Gut-Care® y proteína novel hipoalergénica en polvo mezclado con agua en su ración diaria.',
                ],
            ],
        ];
    }

    /**
     * 12 razas más buscadas y con mayor predisposición dermatológica/digestiva en Colombia
     */
    public static function getBreeds(): array
    {
        return [
            'bulldog-frances' => [
                'slug' => 'bulldog-frances',
                'name' => 'Bulldog Francés',
                'species' => 'perro',
                'weight_range' => '8 a 14 kg',
                'daily_grams' => 5,
                'scoop_label' => '1 cucharadita dosificadora (5g) al día',
                'days_per_bag' => '50 días (1 bolsa de 250g)',
                'predisposition' => 'El Bulldog Francés es la raza #1 en Colombia con predisposición a dermatitis atópica, alergia al pollo, pliegues húmedos y gases intestinales.',
            ],
            'shih-tzu' => [
                'slug' => 'shih-tzu',
                'name' => 'Shih Tzu',
                'species' => 'perro',
                'weight_range' => '4 a 8 kg',
                'daily_grams' => 3.5,
                'scoop_label' => '¾ de cucharadita dosificadora (~3.5g) al día',
                'days_per_bag' => '65 a 70 días (1 bolsa de 250g)',
                'predisposition' => 'El Shih Tzu tiene piel delicada y manto largo que retiene humedad entre los dedos, haciéndolo muy propenso a lamido de patas, lagrimeo oxidado y alergias cutáneas.',
            ],
            'poodle' => [
                'slug' => 'poodle',
                'name' => 'Poodle (French Poodle)',
                'species' => 'perro',
                'weight_range' => '3 a 10 kg',
                'daily_grams' => 4,
                'scoop_label' => '¾ a 1 cucharadita dosificadora (3.5–5g) al día',
                'days_per_bag' => '50 a 65 días (1 bolsa de 250g)',
                'predisposition' => 'El Poodle suele tener piel sensible a proteínas de pollo y champús fuertes, presentando rasquiña en orejas, patas rosadas y estómago delicado.',
            ],
            'bulldog-ingles' => [
                'slug' => 'bulldog-ingles',
                'name' => 'Bulldog Inglés',
                'species' => 'perro',
                'weight_range' => '18 a 25 kg',
                'daily_grams' => 10,
                'scoop_label' => '2 cucharaditas dosificadoras (10g) al día',
                'days_per_bag' => '25 días (recomendado Pack Dúo 2 Bolsas para 50 días)',
                'predisposition' => 'El Bulldog Inglés desarrolla frecuentemente dermatitis en pliegues, pododermatitis interdigital por levaduras y sensibilidad digestiva severa.',
            ],
            'golden-retriever' => [
                'slug' => 'golden-retriever',
                'name' => 'Golden Retriever',
                'species' => 'perro',
                'weight_range' => '25 a 34 kg',
                'daily_grams' => 10,
                'scoop_label' => '2 cucharaditas dosificadoras (10g) al día',
                'days_per_bag' => '25 días (recomendado Pack Dúo 2 Bolsas)',
                'predisposition' => 'El Golden Retriever es propenso a parches calientes (hot spots), caída abundante de subpelo y alergias ambientales y alimentarias.',
            ],
            'pug' => [
                'slug' => 'pug',
                'name' => 'Pug (Carlino)',
                'species' => 'perro',
                'weight_range' => '6 a 9 kg',
                'daily_grams' => 5,
                'scoop_label' => '1 cucharadita dosificadora (5g) al día',
                'days_per_bag' => '50 días (1 bolsa de 250g)',
                'predisposition' => 'El Pug muda pelo todo el año y presenta alta sensibilidad cutánea en pliegues faciales, patas y barriga.',
            ],
            'pomerania' => [
                'slug' => 'pomerania',
                'name' => 'Pomerania',
                'species' => 'perro',
                'weight_range' => '2 a 4 kg',
                'daily_grams' => 2.5,
                'scoop_label' => '½ cucharadita dosificadora (2.5g) al día',
                'days_per_bag' => 'hasta 90–100 días (1 bolsa de 250g)',
                'predisposition' => 'El Pomerania requiere alto soporte de Omega 3-6-9 y proteína limpia para prevenir alopecia X, resequedad del manto doble y caspa.',
            ],
            'yorkshire-terrier' => [
                'slug' => 'yorkshire-terrier',
                'name' => 'Yorkshire Terrier',
                'species' => 'perro',
                'weight_range' => '2 a 4 kg',
                'daily_grams' => 2.5,
                'scoop_label' => '½ cucharadita dosificadora (2.5g) al día',
                'days_per_bag' => 'hasta 90–100 días (1 bolsa de 250g)',
                'predisposition' => 'El Yorkshire Terrier tiene estómago muy sensible (gastritis y heces blandas frecuentes) y piel fina que se irrita rápido con alérgenos del concentrado.',
            ],
            'schnauzer' => [
                'slug' => 'schnauzer',
                'name' => 'Schnauzer Miniatura',
                'species' => 'perro',
                'weight_range' => '5 a 9 kg',
                'daily_grams' => 5,
                'scoop_label' => '1 cucharadita dosificadora (5g) al día',
                'days_per_bag' => '50 días (1 bolsa de 250g)',
                'predisposition' => 'El Schnauzer sufre frecuentemente de síndrome de comedones en el lomo, caspa seborreica y sensibilidad digestiva a grasas saturadas.',
            ],
            'beagle' => [
                'slug' => 'beagle',
                'name' => 'Beagle',
                'species' => 'perro',
                'weight_range' => '9 a 14 kg',
                'daily_grams' => 5,
                'scoop_label' => '1 cucharadita dosificadora (5g) al día',
                'days_per_bag' => '50 días (1 bolsa de 250g)',
                'predisposition' => 'El Beagle suele presentar alergias cutáneas, otitis recurrente y caída constante de pelo corto si su microbiota está inflamada.',
            ],
            'labrador-retriever' => [
                'slug' => 'labrador-retriever',
                'name' => 'Labrador Retriever',
                'species' => 'perro',
                'weight_range' => '25 a 36 kg',
                'daily_grams' => 10,
                'scoop_label' => '2 cucharaditas dosificadoras (10g) al día',
                'days_per_bag' => '25 días (recomendado Pack Dúo 2 Bolsas)',
                'predisposition' => 'El Labrador tiene predisposición genética a alergias alimentarias, lamido de patas y muda intensa de pelo durante todo el año.',
            ],
            'gatos' => [
                'slug' => 'gatos',
                'name' => 'Gatos (Persa, Criollo y Domésticos)',
                'species' => 'gato',
                'weight_range' => '3 a 6 kg',
                'daily_grams' => 2.5,
                'scoop_label' => '½ cucharadita dosificadora (2.5g) al día',
                'days_per_bag' => 'hasta 90–100 días (1 bolsa de 250g)',
                'predisposition' => 'En gatos, la alergia al pollo y los granos se manifiesta con acicalamiento excesivo (zonas sin pelo en barriga), caspa en el lomo, costras miliares y heces blandas.',
            ],
        ];
    }

    /**
     * 10 ciudades principales de Colombia para SEO local BioLab (Envío Contraentrega)
     */
    public static function getBioLabCities(): array
    {
        return [
            'bogota' => [
                'slug' => 'bogota',
                'name' => 'Bogotá',
                'department' => 'Cundinamarca',
                'delivery_eta' => '1 a 2 días hábiles',
                'climate_factor' => 'El clima frío, la lluvia frecuente y la contaminación urbana en Bogotá resecan la piel y aumentan la humedad en las patas tras los paseos, disparando pododermatitis y caspa.',
            ],
            'medellin' => [
                'slug' => 'medellin',
                'name' => 'Medellín',
                'department' => 'Antioquia',
                'delivery_eta' => '2 a 3 días hábiles',
                'climate_factor' => 'En Medellín y el Valle de Aburrá, el polen constante y la humedad moderada potencian las dermatitis alérgicas y el rascado recurrente en razas sensibles.',
            ],
            'cali' => [
                'slug' => 'cali',
                'name' => 'Cali',
                'department' => 'Valle del Cauca',
                'delivery_eta' => '2 a 3 días hábiles',
                'climate_factor' => 'El calor de Cali acelera la muda de pelo y la proliferación de levaduras en pliegues y patas cuando el sistema inmune de la mascota está inflamado.',
            ],
            'barranquilla' => [
                'slug' => 'barranquilla',
                'name' => 'Barranquilla',
                'department' => 'Atlántico',
                'delivery_eta' => '2 a 4 días hábiles',
                'climate_factor' => 'Las altas temperaturas y humedad de Barranquilla favorecen brotes de dermatitis húmeda, mal olor en la piel y caída excesiva de pelo todo el año.',
            ],
            'bucaramanga' => [
                'slug' => 'bucaramanga',
                'name' => 'Bucaramanga',
                'department' => 'Santander',
                'delivery_eta' => '2 a 3 días hábiles',
                'climate_factor' => 'El clima cálido de Bucaramanga incrementa la sensibilidad dérmica, el lamido de patas y la pérdida de brillo en el pelaje.',
            ],
            'cartagena' => [
                'slug' => 'cartagena',
                'name' => 'Cartagena',
                'department' => 'Bolívar',
                'delivery_eta' => '2 a 4 días hábiles',
                'climate_factor' => 'La humedad costera y el calor de Cartagena son el detonante clásico de levaduras en patas, picazón abdominal y pelaje opaco.',
            ],
            'pereira' => [
                'slug' => 'pereira',
                'name' => 'Pereira',
                'department' => 'Risaralda',
                'delivery_eta' => '2 a 3 días hábiles',
                'climate_factor' => 'Las lluvias frecuentes y vegetación del Eje Cafetero elevan la exposición a alérgenos ambientales y humedad entre las almohadillas.',
            ],
            'chia-y-cajica' => [
                'slug' => 'chia-y-cajica',
                'name' => 'Chía y Cajicá',
                'department' => 'Cundinamarca',
                'delivery_eta' => '1 a 2 días hábiles',
                'climate_factor' => 'El pasto húmedo de la Sabana Norte (Chía, Cajicá y Zipaquirá) y el frío matutino disparan alergias por contacto en patas y resequedad cutánea.',
            ],
            'manizales' => [
                'slug' => 'manizales',
                'name' => 'Manizales',
                'department' => 'Caldas',
                'delivery_eta' => '2 a 3 días hábiles',
                'climate_factor' => 'El clima frío y húmedo de Manizales suele generar caspa seca, piel sensible y molestias digestivas cuando la dieta tiene cereales inflamatorios.',
            ],
            'cucuta' => [
                'slug' => 'cucuta',
                'name' => 'Cúcuta',
                'department' => 'Norte de Santander',
                'delivery_eta' => '2 a 4 días hábiles',
                'climate_factor' => 'El calor intenso de Cúcuta aumenta la caída de pelo constante y la irritación cutánea en perros y gatos de hogar.',
            ],
        ];
    }

    /**
     * 3 intenciones comerciales locales para Symptom × City
     */
    public static function getCityProblems(): array
    {
        return [
            'suplemento-alergia-picazon' => [
                'slug' => 'suplemento-alergia-picazon',
                'title' => 'Suplemento para Alergia y Picazón en Perros y Gatos',
                'symptom_key' => 'picazon-y-dermatitis',
            ],
            'solucion-lamido-de-patas' => [
                'slug' => 'solucion-lamido-de-patas',
                'title' => 'Solución para Perro que se Lame las Patas y Pododermatitis',
                'symptom_key' => 'lamido-de-patas',
            ],
            'vitaminas-caida-de-pelo' => [
                'slug' => 'vitaminas-caida-de-pelo',
                'title' => 'Vitaminas y Suplemento para Caída de Pelo y Caspa en Perros',
                'symptom_key' => 'caida-de-pelo-y-caspa',
            ],
        ];
    }

    /**
     * 12 ciudades de Colombia para SEO Programático B2B (Software Veterinario y Planes de Salud)
     */
    public static function getSaasCities(): array
    {
        return [
            'bogota' => ['slug' => 'bogota', 'name' => 'Bogotá', 'department' => 'Cundinamarca', 'avg_plan_cop' => '$59.900', 'market_note' => 'Con la mayor competencia de clínicas veterinarias del país, retener clientes con planes preventivos mensuales y carnet QR marca la diferencia frente a grandes cadenas.'],
            'medellin' => ['slug' => 'medellin', 'name' => 'Medellín', 'department' => 'Antioquia', 'avg_plan_cop' => '$54.900', 'market_note' => 'Los tutores en Medellín y el Valle de Aburrá valoran la experiencia digital: carnet de vacunación QR, recordatorios por WhatsApp y suscripciones preventivas sin filas.'],
            'cali' => ['slug' => 'cali', 'name' => 'Cali', 'department' => 'Valle del Cauca', 'avg_plan_cop' => '$49.900', 'market_note' => 'En Cali, las clínicas que pasan de consultas aisladas a planes preventivos mensuales multiplican sus ingresos recurrentes y reducen meses flojos.'],
            'barranquilla' => ['slug' => 'barranquilla', 'name' => 'Barranquilla', 'department' => 'Atlántico', 'avg_plan_cop' => '$49.900', 'market_note' => 'Digitaliza tu clínica en Barranquilla con historial de vacunas QR, control de desparasitación mensual y cobro automático de planes preventivos.'],
            'bucaramanga' => ['slug' => 'bucaramanga', 'name' => 'Bucaramanga', 'department' => 'Santander', 'avg_plan_cop' => '$45.900', 'market_note' => 'Haz crecer tu veterinaria en Bucaramanga y su área metropolitana fidelizando a cada propietario desde la primera vacuna con carnet digital QR.'],
            'cartagena' => ['slug' => 'cartagena', 'name' => 'Cartagena', 'department' => 'Bolívar', 'avg_plan_cop' => '$49.900', 'market_note' => 'Aumenta la retención de pacientes en Cartagena automatizando recordatorios de profilaxis, baños medicados y vacunas por WhatsApp.'],
            'pereira' => ['slug' => 'pereira', 'name' => 'Pereira', 'department' => 'Risaralda', 'avg_plan_cop' => '$45.900', 'market_note' => 'Moderniza tu clínica veterinaria en Pereira y el Eje Cafetero con página web propia, carnet QR y membresías de salud preventiva.'],
            'chia' => ['slug' => 'chia', 'name' => 'Chía', 'department' => 'Cundinamarca', 'avg_plan_cop' => '$64.900', 'market_note' => 'En Chía el ticket promedio de bienestar animal es alto: ofrece planes de salud preventiva VIP con tu propia marca blanca en menos de 10 minutos.'],
            'cajica' => ['slug' => 'cajica', 'name' => 'Cajicá', 'department' => 'Cundinamarca', 'avg_plan_cop' => '$59.900', 'market_note' => 'Clínicas en Cajicá ya usan AviPetApp para posicionarse en Google, entregar carnet QR a domicilio y convertir visitas sueltas en clientes recurrentes.'],
            'manizales' => ['slug' => 'manizales', 'name' => 'Manizales', 'department' => 'Caldas', 'avg_plan_cop' => '$45.900', 'market_note' => 'Organiza tu veterinaria en Manizales con planes preventivos, control de canjes en mostrador y recordatorios automáticos de vacunación.'],
            'cucuta' => ['slug' => 'cucuta', 'name' => 'Cúcuta', 'department' => 'Norte de Santander', 'avg_plan_cop' => '$42.900', 'market_note' => 'Diferencia tu clínica en Cúcuta ofreciendo carnet digital de vacunación con código QR y planes de salud mensual accesibles para cada familia.'],
            'villavicencio' => ['slug' => 'villavicencio', 'name' => 'Villavicencio', 'department' => 'Meta', 'avg_plan_cop' => '$45.900', 'market_note' => 'Fideliza clientes en Villavicencio con control de vacunas, desparasitación periódica y planes preventivos digitales sin instalaciones complejas.'],
        ];
    }

    public static function resolveBioLabBreed(string $problema, string $raza): ?array
    {
        $symptoms = self::getSymptoms();
        $breeds = self::getBreeds();
        if (!isset($symptoms[$problema]) || !isset($breeds[$raza])) {
            return null;
        }
        return [
            'mode' => 'breed',
            'symptom' => $symptoms[$problema],
            'breed' => $breeds[$raza],
            'related_breeds' => array_slice(array_filter($breeds, fn ($b) => $b['slug'] !== $raza), 0, 6),
            'related_symptoms' => array_filter($symptoms, fn ($s) => $s['slug'] !== $problema),
        ];
    }

    public static function resolveBioLabCity(string $problema, string $ciudad): ?array
    {
        $problems = self::getCityProblems();
        $cities = self::getBioLabCities();
        $symptoms = self::getSymptoms();
        if (!isset($problems[$problema]) || !isset($cities[$ciudad])) {
            return null;
        }
        $problem = $problems[$problema];
        return [
            'mode' => 'city',
            'problem' => $problem,
            'symptom' => $symptoms[$problem['symptom_key']],
            'city' => $cities[$ciudad],
            'related_cities' => array_slice(array_filter($cities, fn ($c) => $c['slug'] !== $ciudad), 0, 6),
            'related_problems' => array_filter($problems, fn ($p) => $p['slug'] !== $problema),
        ];
    }

    public static function resolveSaasCity(string $ciudad): ?array
    {
        $cities = self::getSaasCities();
        if (!isset($cities[$ciudad])) {
            return null;
        }
        return [
            'city' => $cities[$ciudad],
            'other_cities' => array_filter($cities, fn ($c) => $c['slug'] !== $ciudad),
        ];
    }

    /**
     * Genera todas las URLs programáticas para /sitemap.xml
     */
    public static function getAllSitemapPaths(bool $bioLabOnly = false): array
    {
        $paths = ['/salud-mascotas'];

        foreach (array_keys(self::getSymptoms()) as $symptomSlug) {
            foreach (array_keys(self::getBreeds()) as $breedSlug) {
                $paths[] = "/salud-mascotas/{$symptomSlug}-en-{$breedSlug}";
            }
        }

        foreach (array_keys(self::getCityProblems()) as $problemSlug) {
            foreach (array_keys(self::getBioLabCities()) as $citySlug) {
                $paths[] = "/salud-mascotas/colombia/{$problemSlug}-{$citySlug}";
            }
        }

        if (!$bioLabOnly) {
            foreach (array_keys(self::getSaasCities()) as $citySlug) {
                $paths[] = "/software-veterinario/{$citySlug}";
            }
        }

        return $paths;
    }
}
