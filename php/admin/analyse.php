<?php 
session_start();
require '../../include/databaseconnect.php';
if (!isset($_SESSION['user_statut']) || $_SESSION['user_statut'] != "admin") {
    header('Location: ../../index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Analyse des ventes</title>
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../../css/bootstrap.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="icon" type="image/png" href="../../img/icon.png"/>
</head>

<?php include_once('../../include/header.php'); ?>
<script>
    $("#pokemon").addClass("active");  // Fonction pour mettre la class "active" en fonction de la page
</script>

<div class="mt-3 container-fluid pb-3 flex-grow-1 d-flex flex-column flex-sm-row overflow-auto">
    <div class="row flex-grow-sm-1 flex-grow-0 container-fluid">
        <main class="col overflow-auto h-100 w-100">
            <div class="container py-2">
                <h2>Analyse</h2>
                <?php
                // Première requête pour le chiffre d'affaire par commande
                $requete = $bdd->prepare("SELECT id, total FROM commandes ORDER BY date_creation");
                $requete->execute();
                $result = $requete->fetchAll(PDO::FETCH_ASSOC);

                $commandes = array();
                $prix = array();
                foreach ($result as $row) {
                    array_push($commandes, 'Commande ' . $row['id']);
                    array_push($prix, $row['total']);
                }

                // Deuxième requête pour le nombre de commandes par jour
                $requete_commandes = $bdd->prepare("SELECT DATE_FORMAT(date_creation, '%Y-%m-%d') as day, COUNT(*) as total_commandes 
                                                   FROM commandes 
                                                   GROUP BY day 
                                                   ORDER BY day");
                $requete_commandes->execute();
                $result_commandes = $requete_commandes->fetchAll(PDO::FETCH_ASSOC);

                $jours = array();
                $commandes_par_jour = array();
                foreach ($result_commandes as $row) {
                    array_push($jours, $row['day']);
                    array_push($commandes_par_jour, $row['total_commandes']);
                }
                ?>

                <h4>Votre chiffre d'affaire :</h4>
                <canvas id="graphique1"></canvas>
                <script>
                var ctx1 = document.getElementById('graphique1').getContext('2d');
                var graph1 = new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: <?php echo json_encode($commandes); ?>,
                        datasets: [{
                            label: 'Chiffre d\'affaires par commande',
                            data: <?php echo json_encode($prix); ?>,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Somme totale des ventes (€)'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return value + ' €';
                                    },
                                    stepSize: 500  // Ajustez la taille de l'étape selon vos besoins
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Commandes'
                                }
                            }
                        }
                    }
                });
                </script>

                <h4>Nombre de commandes par jour :</h4>
                <canvas id="graphique2"></canvas>
                <script>
                var ctx2 = document.getElementById('graphique2').getContext('2d');
                var graph2 = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($jours); ?>,
                        datasets: [{
                            label: 'Nombre de commandes',
                            data: <?php echo json_encode($commandes_par_jour); ?>,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Nombre de commandes'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Jour'
                                }
                            }
                        }
                    }
                });
                </script>
                <br><br>
            </div>
        </main>
    </div>
</div>

<script type="text/javascript">
function imprimer_page() {
    window.print();
}
</script>
