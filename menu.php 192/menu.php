<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Las Historias</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, Helvetica, sans-serif; background: #fff; }
        .menu-historias { width: 100%; color: #fff; }
        .barra-superior { height: 34px; display: flex; justify-content: flex-end; align-items: center; gap: 55px; padding: 0 28px; background: #651c1c; border-bottom: 1px solid rgba(255,255,255,.2); font-size: 12px; }
        .barra-superior a { color: #fff; text-decoration: none; opacity: .9; }
        .barra-superior i { margin-right: 6px; }
        .barra-principal { min-height: 70px; display: flex; align-items: stretch; padding: 0 26px; background: linear-gradient(90deg, #681c1c, #8d302c); box-shadow: 0 2px 5px rgba(0,0,0,.22); }
        .marca { display: flex; align-items: center; margin-right: auto; color: #fff; text-decoration: none; }
        .marca-icono { margin-right: 10px; font-size: 18px; }
        .marca-texto { font-family: Georgia, 'Times New Roman', serif; font-size: 29px; font-style: italic; letter-spacing: .5px; }
        .enlaces { display: flex; align-items: stretch; }
        .enlaces a { min-width: 125px; display: flex; justify-content: center; align-items: center; padding: 0 20px; color: #f6eaea; text-decoration: none; font-size: 14px; transition: .2s; }
        .enlaces a:hover, .enlaces a.activo { color: #4c1717; background: #fff; }
        @media (max-width: 700px) {
            .barra-superior { display: none; }
            .barra-principal { padding: 12px; flex-direction: column; }
            .marca { margin: 0 0 10px; }
            .enlaces { flex-wrap: wrap; }
            .enlaces a { min-width: 50%; padding: 12px 8px; }
        }
    </style>
</head>
<body>
<header class="menu-historias">
    <div class="barra-superior">
        <a href="#"><i class="fa-brands fa-facebook-f"></i> Facebook</a>
        <a href="#"><i class="fa-brands fa-instagram"></i> Instagram</a>
    </div>
    <nav class="barra-principal" aria-label="Menú principal">
        <a class="marca" href="#">
            <i class="fa-solid fa-angles-right marca-icono"></i>
            <span class="marca-texto">Las Historias</span>
        </a>
        <div class="enlaces">
            <a class="activo" href="frmcliente.php">Historia</a>
            <a href="#">Galería</a>
            <a href="#">Recomendación</a>
            <a href="#">Materiales</a>
        </div>
    </nav>
</header>