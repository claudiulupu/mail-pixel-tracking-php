<!DOCTYPE html>
<html>
	<head>
		<title>Email Tracking</title>
	</head>
    <style>        
        body {
            width: 98%;
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
            width: 100%;
			font-size: 1.2em;
            border-collapse: collapse;
        }
        th, td {
            border: 2px solid black;
			font-size: 0.9em;	
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

        function dev_red(btn,id){
            divs = ['search','learn','add','history']; 
            for(i=0; i < divs.length; i++){
                document.getElementById(divs[i]).style.display = 'none';
                document.getElementById("button_"+divs[i]).style.background = 'white';
                document.getElementById("button_"+divs[i]).style.color = 'black';
            }
            document.getElementById(id).style.display = 'block';
            btn.style.background = 'green';
            btn.style.color = 'white';
        }

        function toggle(source,div) {
            var checkboxes = document.getElementsByClassName('tabcheck_'+div);
            for(i=0; i < checkboxes.length; i++){
                checkboxes[i].checked = source.checked;
            }
        }

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
            if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['idmail'])) {
                $sqlsearchmail = $pdo->prepare("SELECT * FROM mail WHERE id=?");
                $sqlsearchmail->execute([$_GET['idmail']]);
                $rowmail = $sqlsearchmail->fetch(PDO::FETCH_ASSOC);
                if ( ! $rowmail) {
        ?>
        <label>Les logs sont les suivants</label><br><br>

        <table id="mail-table">
            <tr>
                <th>idclient</th>
                <th>ip</th>
                <th>port</th>
                <th>useragent</th>
                <th>browser</th>
                <th>os</th>
                <th>isp</th>
                <th>zip</th>
                <th>city</th>
                <th>region</th>
                <th>country</th>
                <th>lat</th>
                <th>lon</th>
            </tr>
                <?php 
                    $idmail = $_GET['idmail'];
                    $sql = $pdo->query("SELECT * FROM client INNER JOIN log ON client.idclient=log.idclient WHERE idmail=$idmail ORDER BY log.datetime DESC");
                    // $resultsearch = $sql->fetchall();
                    foreach($sql as $row){ 
                ?>
                <tr>
                    <td><?php echo $row['idclient'] ?></td>
                    <td><?php echo $row['ip'] ?></td>
                    <td><?php echo $row['port'] ?></td>
                    <td><?php echo $row['useragent'] ?></td>
                    <td><?php echo $row['browser'] ?></td>
                    <td><?php echo $row['os'] ?></td>
                    <td><?php echo $row['isp'] ?></td>
                    <td><?php echo $row['zip'] ?></td>
                    <td><?php echo $row['city'] ?></td>
                    <td><?php echo $row['region'] ?></td>
                    <td><?php echo $row['country'] ?></td>
                    <td><?php echo $row['lat'] ?></td>
                    <td><?php echo $row['lon'] ?></td>
                </tr>
                <?php
                    }
                }
            }
        ?>
        </table>
        </div>

    </div>
	</body>
</html>

