// Call function calls the php function from an HTML button
// and calls the appropriate one using url queries
function call(str) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("demo").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "maze.php?q=" + str, true);
    xhttp.send();
}