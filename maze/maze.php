


<?php

session_start();


// The main maze abstract class
abstract class Maze {

    abstract protected function getDescription();

    public function description() {
        print "<p>" . $this->getDescription() . "</p>";
    }
}

class Enemy extends Maze {
    protected function getDescription() {
        return 'The enemy is here... Lack of inspiration clouds your mind, Desperation overshadows your pride,
        all is lost. You have dropped out and now flips burgers at KR\'s.
        <br /><button type=\'button\' onclick="call(\'start\')">Start Over</button>';
    }
}

class Fork extends Maze {
    private $left, $right;

    public function __construct($left, $right) {
        $this->left = $left;
        $this->right = $right;
    }

    protected function getDescription() {
        return 'You\'ve studied hard for the first year, copying code from your classmates, and begging the T.A.\'s until they gave you the answer. Now you have a real choice to make. 222 or  333?<br />
                <button type=\'button\' onclick="call(\'left\')">222</button>
                <button type=\'button\' onclick="call(\'right\')">333</button>';
    }

    public function goLeft() {
        $this->left->description();
        $_SESSION['maze'] = $this->left;
    }

    public function goRight() {
        $this->right->description();
        $_SESSION['maze'] = $this->right;
    }



}





class Hallway extends Maze {
    private $hall;

    public function __construct($hall) {
        $this->hall = $hall;
    }

    protected function getDescription() {
        return 'Just walking through the halls of hickman, wondering if you ever gonna graduate, get married, or is this all worth it.<br />
                <button type=\'button\' onclick="call(\'continue\')">Continue on</button>';
    }

    public function goAhead() {
        $this->hall->description();
        $_SESSION['maze'] = $this->hall;
    }
}




class DeadEnd extends Maze {
    protected function getDescription() {
        return 'Ha You failed repeat! repeat! repeat!!!!!111!!!!!!<br />Would you like to try againr?
        <br /><button type=\'button\' onclick="call(\'start\')">I mean I knda don\'t have a choice</button>';
    }
}

class DeadEndDetermination extends Maze {
  private  $determined,  $switch;

  public function __construct(  $switch,$determined) {
      $this->determined = $determined;
      $this->switch = $switch;
  }

    protected function getDescription() {
        return 'Ha You got a 0 on your final Exam. :(  You failed, lost, cried. What are you going to do?
        <br /><button type=\'button\' onclick="call(\'switch\')">Switch majors</button>
        <br /><button type=\'button\' onclick="call(\'determination\')">Determination</button>';
    }

    public function getDetermined() {
        $this->determined->description();
        $_SESSION['maze'] = $this->determined;
    }

    public function switch() {
        $this->switch->description();
        $_SESSION['maze'] = $this->switch;
    }
}

class Exits extends Maze {
    protected function getDescription() {
        return 'The year is 2030, you have repeated 222 at least 5 times now, but hey who cares you here, you graduate
        , you got a girl, you found a stable job at McKee. All is well. Would you like to play again?
        <br /><button type=\'button\' onclick="call(\'start\')">Start Over</button>';
    }
}

class Entrance extends Maze {
    private $maz;

    public function __construct($maz) {
        $this->maz = $maz;
    }

    protected function getDescription() {
        return '<h3>You\'re journey as a comp. sci student at SAU starts here.
                    If you win you might get a job. who knows? You Ready?</h3><br />
                <br />
                <br /><button type=\'button\' onclick="call(\'begin\')">No</button>
                <br />
                <br /><button type=\'button\' onclick="call(\'begin\')">Definitely No</button>
                <br />';
    }

    public function play() {
        $this->maz->description();
        $_SESSION['maze'] = $this->maz;
    }
}

// Read the queries from the url to find the right function at the if statement
$q = isset($_REQUEST['q']) ? $_REQUEST['q'] : null;
// Pull the current maze from the session (only a maze if game has been started)
$maze = $_SESSION['maze'];

if ($q === "start") {
  //path to take
    $maze = new Entrance(new Hallway (new Fork
                                              (new Hallway
                                              (new DeadEndDetermination((new Enemy), new Exits)
                                            ), new Exits)));
    $_SESSION['maze'] = $maze;
    $maze->description();
}
elseif ($q === "begin") {
    $maze->play();
}
elseif ($q === "continue") {
    $maze->goAhead();

}
elseif ($q === "left") {
    $maze->goLeft();

}
elseif ($q === "right") {
    $maze->goRight();
}
elseif ($q === "determination") {
    $maze->getDetermined();
}
elseif ($q === "switch") {
    $maze->switch();
}
?>
