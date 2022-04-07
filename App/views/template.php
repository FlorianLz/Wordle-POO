<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');
        .OK {
            background-color: green;
        }
        .KO {
            background-color: red;
        }
        .BP {
            background-color: blue;
        }
        body{
            background-color: #273c75;
            max-width: 700px;
            margin: 0 auto;
            font-family: Roboto, sans-serif;
            color: white;
        }
        form{
            margin-top: 1.3rem;
        }
        form div{
            display: flex;
        }
        form input[type="text"]{
            width: 30px;
            height: 30px;
            margin-right: 0.5rem;
        }
        form input[type="submit"]{
            background-color: #00a8ff;
            padding: 0.5rem 2.5rem;
            border: none;
            cursor: pointer;
            color: white;
            margin: 1.7rem auto 0;
        }
        div.proposition{
            display: flex;
            margin-bottom: 0.5rem;
        }
        span{
            width: 30px;
            height: 30px;
            margin-right: 0.5rem;
            border: none;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        button{
            background-color: #00a8ff;
            padding: 0.5rem 2.5rem;
            border: none;
            cursor: pointer;
            color: white;
            margin: 1.5rem auto 0;
        }
        .divBtn{
            width: 100%;
            text-align: right;
        }
    </style>
    <title>Wordle</title>
</head>
<body>
    <h1>Bienvenue sur le jeu du Wordle !</h1>
    <?php if ($wordle->essais_restants > 0 && $wordle->status === "PLAYING"){ ?>
    <p>Il te reste encore <?= $wordle->essais_restants ?> tentatives</p>
    <?php } ?>

    <?php if ($wordle->essais_restants == 0 && $wordle->status === "LOSE"){ ?>
        <p>Vous avez perdu !</p>
        <p>Le mot a trouver était : <?= $wordle->word ?></p>
    <?php } ?>
    <?php if ($wordle->status === "WIN"){ ?>
        <p>Vous avez gagné !</p>
        <p>Le mot a trouver était bien : <?= $wordle->word ?></p>
    <?php } ?>

    <?php
    if(count($wordle->tentatives)>0){
        if($wordle->status === "WIN"){
            if(count($wordle->tentatives) > 1 ){
                echo '<h2>Trouvé en '.count($wordle->tentatives). ' essais</h2>';
            }else{
                echo '<h2>Trouvé en '.count($wordle->tentatives). ' essai</h2>';
            }
        }else{
            echo '<h2>Tes derniers essais :</h2>';
        }

    foreach ($wordle->tentatives as $tentative){ ?>
        <div class="proposition">
            <?php  for ($i=0; $i < $wordle->word_count; $i++){
                echo '<span class="'.$tentative[$i]->status.'">'.$tentative[$i]->letter.'</span>';
                 ?>
            <?php } ?>
        </div>
    <?php } } ?>
<?php if($wordle->essais_restants > 0 && $wordle->status === "PLAYING"){ ?>
   <h2>Nouvelle tentative :</h2>
        <form method="GET">
            <div>
            <?php
            foreach ($wordle->tabLettres as $key => $letter) {
                ?>
                <input type="text" maxlength="1" name="letter<?= $key ?>">
                <?php
            }
            ?>
            </div>
            <input type="submit">
        </form>
<?php } ?>
    <div class="divBtn">
        <button onclick="reloadPage()">Recommencer avec un autre mot</button>
    </div>
    <script>
        function reloadPage() {
            document.cookie = 'gameData=; Max-Age=-99999999;';
            window.location.href = '/';
        }
    </script>
</body>
</html>