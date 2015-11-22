<?php
    # get connection string
    $ip = getenv("IP");
    $user = getenv("C9_USER");
    # connect to mySql
    mysql_connect("$ip","$user");
    # select database
    mysql_select_db("world");
    
    # accept a country
    # respond with a value
    $LOOKUP = $_REQUEST['lookup'];
    $ALL=$_REQUEST['all'];
    $FORMAT = $_REQUEST['format'];

    if ($ALL == true and $LOOKUP == null)
    {
        # execute a SQL query on the database (ALL)
        $query = "SELECT name,head_of_state FROM countries";
        $results = mysql_query($query);
        
        if ($FORMAT == 'xml')
        {
            # XML setup
            header("Content-type: text/xml");
            $stringX = '<countrydata>';
            while ($rows = mysql_fetch_array($results)) 
            {
                $stringX .= '<country>';
                $stringX .= '<name>'.utf8_encode($rows["name"]).'</name>';
                $stringX .= '<ruler>'.utf8_encode($rows["head_of_state"]).'</ruler>';
                $stringX .= '</country>';
            }
            $stringX .= '</countrydata>';
            $xml=  new SimpleXMLElement($stringX);
            echo $xml->asXML();
        }
        else
        {
            # loop through each country
            while ($rows = mysql_fetch_array($results)) 
            {
                ?>
                  <li> <?php echo $rows["name"]; ?>, ruled by <?php echo $rows["head_of_state"]; ?> </li>
                <?php
            }
        }
    }
    else
    {
        # execute a SQL query on the database (LOOKUP)
        $sql = "SELECT * FROM countries WHERE name LIKE '%$LOOKUP%'";
        $result = mysql_query($sql);
        print $result;
        # loop through each country
        while ($row = mysql_fetch_array($result)) 
        {
            ?>
              <li> <?php echo $row["name"]; ?>, ruled by <?php echo $row["head_of_state"]; ?> </li>
            <?php
        }
    }
    
    
?>