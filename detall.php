<?php
require_once "dades.php";

$titolPagina = "Detall de l'encàrrec";
$valid = false;

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = (int) $_GET["id"];
    if ($id >= 0 && $id < count($encarrecs)) {
        $valid = true;
        $encarrec = $encarrecs[$id];
    }
}

include "header.php";
?>

<p><a href="index.php">Tornar al gestor</a></p>

<?php if ($valid) { ?>
    <section class="detall">
        <p class="petit">DETALL DE L'ENCÀRREC #<?php echo $id; ?></p>
        <h1><?php echo htmlspecialchars($encarrec["titol"]); ?></h1>
        <p>Projecte encarregat per <strong><?php echo htmlspecialchars($encarrec["client"]); ?></strong></p>
        <hr>
        <p><span class="petit">CLIENT</span><br><strong><?php echo htmlspecialchars($encarrec["client"]); ?></strong></p>
        <p><span class="petit">HORES ESTIMADES</span><br><strong><?php echo $encarrec["hores"]; ?> hores</strong></p>
        <p><span class="petit">ESTAT</span><br><strong><?php echo $encarrec["estat"]; ?></strong></p>
        <p><span class="petit">ETIQUETES</span><br>
            <strong>
                <?php foreach ($encarrec["etiquetes"] as $etiqueta) { ?>
                    <?php echo htmlspecialchars($etiqueta); ?> ·
                <?php } ?>
            </strong>
        </p>
    </section>
<?php } else { ?>
    <p class="avis error">L'encàrrec no existeix o l'id no és vàlid.</p>
<?php } ?>

<?php include "footer.php"; ?>
