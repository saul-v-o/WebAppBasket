<?php
/**
 * Archivo para ver todas las estadísticas de todos los equipos del torneo
 * 
 * @author Saúl Valenzuela Osuna
 * @version 1.0   26-12-2024
 */
require('../../libs/fpdf/fpdf.php');

/**
 * @var string URL de la API para obtener los juegos de cierto torneo
 */
$apiJuegos = "https://practicas.fimaz.uas.edu.mx/~lisi4104/WEBAPPBASKET/api/games/getGames.php?idTorneo=";

/**
 * @var string Variable que contiene el id del torneo
 */
$idTorneo = $_GET['idTorneo'];

/**
 * @var string Variable que contiene el las fechas de la semana seleccionada
 */
$selectedDate = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');

/**
 * @var string Variable que contiene el id del grupo seleccionado
 */
$selectedGroupId = isset($_GET['idGrupo']) ? $_GET['idGrupo'] : null;

/**
 * @var string Variable que contiene el día del inicio de la semana seleccionada
 */
$inicioSemana = date('Y-m-d', strtotime('monday this week', strtotime($selectedDate)));

/**
 * @var string Variable que contiene el día del fin de la semana seleccionada
 */
$finSemana = date('Y-m-d', strtotime('sunday this week', strtotime($selectedDate)));

/**
 * @var bool|string Variable que contiene la respuesta de la API
 */
$responseJuegos = file_get_contents($apiJuegos . $idTorneo . "&idGrupo=" . $selectedGroupId);

/**
 * @var array|null Variable que contiene los juegos de la semana seleccionada
 */
$juegos = json_decode($responseJuegos, true);

/**
 * @var array Variable que contiene los juegos de la semana 
 */
$juegosSemanaActual = [];

foreach ($juegos as $juego) {
    /**
     * @var string Variable que contiene la fecha del juego en formato 'Y-m-d'
     */
    $fechaDelJuego = date('Y-m-d', strtotime($juego['fecha']));

    // Comprobar si la fecha del juego está dentro del rango de la semana
    if ($fechaDelJuego >= $inicioSemana && $fechaDelJuego <= $finSemana) {
        $juegosSemanaActual[] = $juego;
    }
}

/**
 * @var FPDF Variable-instancia de la clase FPDF
 */
$pdf = new FPDF('L'); 
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, utf8_decode('Rol Semanal'), 0, 1, 'C');

$pdf->Ln(5); 
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, utf8_decode("Semana del $inicioSemana al $finSemana"), 0, 1, 'C');

/**
 * @var int Total del ancho de una página tamaño A4 en horizontal
 * 
 * NOTA: el original es de 295, se redujo para evitar que la tabla se salga de la página
 */
$totalWidth = 285; 

/**
 * @var array Variable que contiene los anchos de cada columna según lo que sea
 */
$columnWidths = [
    25, // Equipo Local
    25, // Equipo Visitante
    20, // Fecha
    20, // Hora
    20, // Rol
    25, // Sede
    20, // Categoría
    20, // Marcador Local
    20  // Marcador Visitante
];

/**
 * @var int Variable que guarda la suma de cada columna
 */
$sumColumnWidths = array_sum($columnWidths);

/**
 * @var float|int Variable que guardará el "factor" para poder escalar cada columna
 */
$scalingFactor = $totalWidth / $sumColumnWidths;
$scaledWidths = array_map(function ($width) use ($scalingFactor) {
    return $width * $scalingFactor;
}, $columnWidths);

// Cabecera de la tabla
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(200, 220, 255);
$pdf->Cell($scaledWidths[0], 10, utf8_decode('Equipo Local'), 1, 0, 'C', true);
$pdf->Cell($scaledWidths[1], 10, utf8_decode('Equipo Visitante'), 1, 0, 'C', true);
$pdf->Cell($scaledWidths[2], 10, utf8_decode('Fecha'), 1, 0, 'C', true);
$pdf->Cell($scaledWidths[3], 10, utf8_decode('Hora'), 1, 0, 'C', true);
$pdf->Cell($scaledWidths[4], 10, utf8_decode('Rol'), 1, 0, 'C', true);
$pdf->Cell($scaledWidths[5], 10, utf8_decode('Sede'), 1, 0, 'C', true);
$pdf->Cell($scaledWidths[6], 10, utf8_decode('Categoría'), 1, 0, 'C', true);
$pdf->Cell($scaledWidths[7], 10, utf8_decode('Marcador Local'), 1, 0, 'C', true);
$pdf->Cell($scaledWidths[8], 10, utf8_decode('Marcador Visitante'), 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
foreach ($juegosSemanaActual as $juego) {
    $pdf->Cell($scaledWidths[0], 10, utf8_decode($juego['nombreEquipoLocal']), 1);
    $pdf->Cell($scaledWidths[1], 10, utf8_decode($juego['nombreEquipoVisitante']), 1);
    $pdf->Cell($scaledWidths[2], 10, utf8_decode($juego['fecha']), 1);
    $pdf->Cell($scaledWidths[3], 10, utf8_decode($juego['hora']), 1);
    $pdf->Cell($scaledWidths[4], 10, utf8_decode($juego['rol']), 1);
    $pdf->Cell($scaledWidths[5], 10, utf8_decode($juego['sede']), 1);
    $pdf->Cell($scaledWidths[6], 10, utf8_decode($juego['categoria']), 1);
    
    $pdf->Cell($scaledWidths[7], 10, utf8_decode($juego['estatus'] != "pendiente" ? $juego['marcadorLocal'] : 'Pendiente'), 1);
    $pdf->Cell($scaledWidths[8], 10, utf8_decode($juego['estatus'] != "pendiente" ? $juego['marcadorVisitante'] : 'Pendiente'), 1, 1);
}

// Generar el PDF
$pdf->Output('D', 'Rol_Semanal.pdf');
?>
