<?php
require_once "dades.php";

$titolPagina = "Gestor d'encàrrecs";
$missatge = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST["accio"] == "afegir") {
        $titol = $_POST["titol"];
        $client = $_POST["client"];
        $hores = $_POST["hores"];
        $estat = $_POST["estat"];

        if ($titol == "" || $client == "") {
            $error = "El títol i el client són obligatoris.";
        } elseif (!is_numeric($hores) || $hores <= 0) {
            $error = "Les hores han de ser un número més gran que 0.";
        } else {
            $etiquetes = [];
            if ($_POST["etiqueta1"] != "") {
                $etiquetes[] = $_POST["etiqueta1"];
            }
            if ($_POST["etiqueta2"] != "") {
                $etiquetes[] = $_POST["etiqueta2"];
            }
            if ($_POST["etiqueta3"] != "") {
                $etiquetes[] = $_POST["etiqueta3"];
            }

            $nouEncarrec = [
                "titol" => $titol,
                "client" => $client,
                "hores" => $hores,
                "estat" => $estat,
                "etiquetes" => $etiquetes
            ];
            $encarrecs[] = $nouEncarrec;
            $missatge = "L'encàrrec s'ha afegit correctament. Recorda que només existirà durant aquesta resposta.";
        }
    }

    if ($_POST["accio"] == "eliminar") {
        $idEliminar = $_POST["id"];
        $nousEncarrecs = [];
        foreach ($encarrecs as $id => $encarrec) {
            if ($id != $idEliminar) {
                $nousEncarrecs[] = $encarrec;
            }
        }
        $encarrecs = $nousEncarrecs;
        $missatge = "Encàrrec eliminat.";
    }
}

$totalEncarrecs = count($encarrecs);
$horesTotals = 0;
foreach ($encarrecs as $encarrec) {
    $horesTotals = $horesTotals + $encarrec["hores"];
}

include "header.php";
?>

<section class="hero">
    <h1>Gestor d'encàrrecs</h1>
    <p>Consulta la feina de l'equip, revisa les hores previstes i registra encàrrecs nous.</p>
    <a class="boto groc" href="#formulari">+ Nou encàrrec</a>
</section>

<?php if ($missatge != "") { ?>
    <p class="avis ok"><?php echo $missatge; ?></p>
<?php } ?>
<?php if ($error != "") { ?>
    <p class="avis error"><?php echo $error; ?></p>
<?php } ?>

<section class="resum">
    <div class="caixa">Total d'encàrrecs <strong><?php echo $totalEncarrecs; ?></strong></div>
    <div class="caixa">Hores estimades <strong><?php echo $horesTotals; ?> h</strong></div>
</section>

<h2>Llistat d'encàrrecs</h2>
<section class="llistat">
    <?php foreach ($encarrecs as $id => $encarrec) { ?>
        <?php
        $classeEstat = "estat--pendent";
        if ($encarrec["estat"] == "Acabat") {
            $classeEstat = "estat--acabat";
        } elseif ($encarrec["estat"] == "En procés") {
            $classeEstat = "estat--proces";
        }
        ?>
        <article class="targeta">
            <div class="fila">
                <span class="estat <?php echo $classeEstat; ?>"><?php echo $encarrec["estat"]; ?></span>
                <span><?php echo $encarrec["hores"]; ?> h</span>
            </div>
            <h3><?php echo htmlspecialchars($encarrec["titol"]); ?></h3>
            <p>Client: <strong><?php echo htmlspecialchars($encarrec["client"]); ?></strong></p>
            <p class="etiquetes">
                <?php foreach ($encarrec["etiquetes"] as $etiqueta) { ?>
                    <?php echo htmlspecialchars($etiqueta); ?> ·
                <?php } ?>
            </p>
            <div class="fila">
                <a class="boto" href="detall.php?id=<?php echo $id; ?>">Veure detall</a>
                <form method="post">
                    <input type="hidden" name="accio" value="eliminar">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <button class="boto vermell" type="submit">Eliminar</button>
                </form>
            </div>
        </article>
    <?php } ?>
</section>

<section id="formulari" class="formulari">
    <h2>Afegir un encàrrec</h2>
    <p>Emplena les dades. Pots posar fins a 3 etiquetes.</p>
    <form method="post">
        <input type="hidden" name="accio" value="afegir">

        <label for="titol">Títol</label>
        <input type="text" id="titol" name="titol" placeholder="Ex.: Redisseny d'una botiga">

        <label for="client">Client</label>
        <input type="text" id="client" name="client" placeholder="Nom del client">

        <label for="hores">Hores estimades</label>
        <input type="number" id="hores" name="hores">

        <label for="estat">Estat</label>
        <select id="estat" name="estat">
            <option>Pendent</option>
            <option>En procés</option>
            <option>Acabat</option>
        </select>

        <label>Etiquetes</label>
        <input type="text" name="etiqueta1" placeholder="Etiqueta 1 (ex.: PHP)">
        <input type="text" name="etiqueta2" placeholder="Etiqueta 2 (ex.: Docker)">
        <input type="text" name="etiqueta3" placeholder="Etiqueta 3 (ex.: Responsive)">

        <button class="boto groc" type="submit">Afegir encàrrec</button>
    </form>
</section>

<?php include "footer.php"; ?>
