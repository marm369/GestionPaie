<!DOCTYPE html>
<html>
<head>
  <title>Mon Interface RP</title>
  <style>
    body {
      background-color: #f0f8ff; /* Bleu glacé */
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    
    h1 {
      color: #000080; /* Bleu */
      text-align: center;
      padding: 20px;
    }
    
    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      background-color: #ffffff; /* Blanc */
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    label {
      color: #000080; /* Bleu */
      font-weight: bold;
    }
    
    input[type=text], textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #000080; /* Bleu */
      border-radius: 4px;
      box-sizing: border-box;
      margin-bottom: 10px;
    }
    
    input[type=submit] {
      background-color: #000080; /* Bleu */
      color: #ffffff; /* Blanc */
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    
    input[type=submit]:hover {
      background-color: #0000ff; /* Bleu plus clair au survol */
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Mon Interface RP</h1>
    
    <form>
      <label for="nom">Nom :</label>
      <input type="text" id="nom" name="nom" placeholder="Entrez votre nom">
      
      <label for="message">Message :</label>
      <textarea id="message" name="message" placeholder="Entrez votre message"></textarea>
      
      <input type="submit" value="Envoyer">
    </form>
  </div>
</body>
</html>
