<!DOCTYPE html>
<style>
  body{
     background-image: url("https://images-na.ssl-images-amazon.com/images/I/212YMx4135L._SX322_BO1,204,203,200_.jpg");
  }
  
  button{
      color: white;
      background-color: green;
  }
  
</style>

<html>
    <head>
        <title>Maze</title>
        <script type="text/javascript" src="ajax.js"></script>
    </head>
    <body onload="call('start')">
        <div style="margin:auto;width:50%;text-align:center;position:relative;">
            <h1>Maze Southern Edition!</h1>

            <!-- The div here is where the php code gets updated with an ajax call -->
            <div id="demo"></div>
        </div>
        <!-- Footer -->
        <footer>
            <a href="../index.php">Home</a>
        </footer>
    </body>
</html>
