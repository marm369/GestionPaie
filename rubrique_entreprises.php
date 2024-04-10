

<!DOCTYPE html>
<html>
<head>
   
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f1f1f1;
        }

        h1 {
            color: blue;
            text-align: center;
        }

        h2 {
            margin-top: 20px;
            color: blue;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            border: 2px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="text"], input[type="submit"] {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: none;
        }

        input[type="submit"] {
            background-color: #87ceeb;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>
<body>
   
    <form method="POST" action="consulter_entreprise.php">
        <label for="nomEntreprise">Nom de l'entreprise :</label>
        <input type="text" name="nomEntreprise" id="nomEntreprise" required>
        <br>
        <input type="submit" value="Envoyer">
    </form>
</body>
</html>
