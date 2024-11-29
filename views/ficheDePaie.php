<?php
include 'header.php';
?>

    <style>
        .fiche-paie {
            margin-top: 20px;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
        }
        .total {
            font-weight: bold;
            background-color: #f9f9f9;
        }
    </style>

<div class="container fiche-paie">
    <h2 class="text-center pb-4" >Fiche de Paie</h2>
    <!-- Informations Générales -->
    <div class="row mb-4">
        <div class="col-md-6">
            <p><strong>Nom et Prénom :</strong> John Doe</p>
            <p><strong>ID :</strong> 12345</p>
            <p><strong>Fonction :</strong> Développeur</p>
            <p><strong>Date d'Embauche :</strong> 01/01/2020</p>
            <p><strong>Ancienneté :</strong> 4 ans</p>
        </div>
        <div class="col-md-6">
            <p><strong>Classification :</strong> A1</p>
            <p><strong>Salaire de Base :</strong> 1,500 EUR</p>
            <p><strong>Taux Journalier :</strong> 75 EUR</p>
            <p><strong>Taux Horaire :</strong> 10 EUR</p>
            <p><strong>Indice :</strong> 2.0</p>
        </div>
    </div>

    <!-- Tableau des Détails -->
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Designation</th>
                <th>Nombre</th>
                <th>Taux</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Salaire de Base</td>
                <td>1</td>
                <td>1,500 EUR</td>
                <td>1,500 EUR</td>
            </tr>
            <tr>
                <td>Prime de Performance</td>
                <td>1</td>
                <td>200 EUR</td>
                <td>200 EUR</td>
            </tr>
            <tr>
                <td>Indemnité Transport</td>
                <td>1</td>
                <td>50 EUR</td>
                <td>50 EUR</td>
            </tr>
            <!-- Totaux -->
            <tr class="total">
                <td colspan="3">Total Salaire Brut</td>
                <td>1,750 EUR</td>
            </tr>
            <tr class="total">
                <td colspan="3">Retenue CNAPS (1%)</td>
                <td>-17.50 EUR</td>
            </tr>
            <tr class="total">
                <td colspan="3">Retenue Sanitaire</td>
                <td>-10 EUR</td>
            </tr>
            <tr class="total">
                <td colspan="3">Tranches IRSA</td>
                <td>-30 EUR</td>
            </tr>
            <tr class="total">
                <td colspan="3">Total Retenues</td>
                <td>-57.50 EUR</td>
            </tr>
            <tr class="total">
                <td colspan="3">Autres Indemnités</td>
                <td>20 EUR</td>
            </tr>
            <tr class="total">
                <td colspan="3">Net à Payer</td>
                <td>1,712.50 EUR</td>
            </tr>
        </tbody>
    </table>
</div>
