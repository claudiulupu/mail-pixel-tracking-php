<!DOCTYPE html>
<html>
	<head>
		<title>Email Tracking</title>
	</head>
    <style>        
        body {
            width: 90%;
            margin: 0 auto;
			font-family: verdana;
			text-align: center;
			padding: 1em;
        }
        h1{
			font-size: 1.8em;
		}
		p,label{
            font-size: 1em;	
		}
        table {
            margin: 0 auto;
            border: 1px solid black;
            width: 95%;
			font-size: 1.2em;
            border-collapse: collapse;
        }
        th, td {
            border: 2px solid black;
			font-size: 1.2em;	
            border-radius: 1em;
        }
        tr {
            color: black;
            background-color: white;
        }
        tr:hover {
            color: white;
            background-color: grey;
        }

        .td_subject {
			text-align: left;
        }
    </style>

    <script type="text/javascript">
        function searchmail (input) {
            var mails = Array.from(document.getElementsByClassName("td_subject"));
            var regex = new RegExp(input,'i');

            if(!input) {
                mails.forEach( (item, index) => {
                    item.parentNode.style.display='table-row';
                })
            }
            else{
                mails.forEach( (item,index) => {
                    item.parentNode.style.display='none';
                    if (regex.test(item.innerText)){
                        item.parentNode.style.display='table-row';
                    }
                })
            }
        }
    </script>
	<body>



    <div id="body">
        <?php
            $dsn = "mysql:host={{host}};dbname={{dbname}}";
            $user = "{{username}}";
            $passwd = "{{password}}";
            $pdo = new PDO($dsn, $user, $passwd);
        ?>
        <label>Chercher un mail dans la liste : </label><br><br>
	    <input oninput="searchmail(this.value);">

        <table id="mail-table">
        <tr>
            <th>idmail</th>
            <th>subject</th>
            <th>datetime</th>
        </tr>
            <?php 
                $sql = $pdo->query("SELECT * from mail ORDER BY `datetime` DESC");
                $resultsearch = $sql->fetchall();
                foreach($resultsearch as $row){ 
            ?>
                <tr class="tr_mail">
                    <td class="td_idmail"><?php echo $row['idmail'] ?></td>
                    <td class="td_subject"><a href=mail.php?idmail=<?php echo $row['idmail'] ?>><?php echo $row['subject'] ?></a></td>
                    <td class="td_datetime"><?php echo $row['datetime'] ?></td>
                </tr>
            <?php
                }
            ?>
        </table>
        </div>

    </div>
	</body>
</html>

