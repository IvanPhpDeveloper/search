<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Поиск...</title>
</head>

<body>
    <form method="get" action="">
        <input type="search" name="k" placeholder="Search...">
        <input type="submit" name="submit">


    </form>



    <?php
    $k = isset($_GET['k']) ? $_GET['k'] : '';

    
    $search_string = "SELECT * FROM search_engine WHERE ";
    $display_words = "";
                        
    
    $keywords = explode(' ', $k);			
    foreach ($keywords as $word){
        $search_string .= "keywords LIKE '%".$word."%' OR ";
        $display_words .= $word.' ';
    }

    $search_string = substr($search_string, 0, strlen($search_string)-4);
    $display_words = substr($display_words, 0, strlen($display_words)-1);

    $conn = mysqli_connect("localhost", "root", "", "search");

    
    $query = mysqli_query($conn, $search_string);
    $result_count = mysqli_num_rows($query);
    
  
    echo '<div class="right"><b><u>'.number_format($result_count).'</u></b> results found</div>';
    echo 'Your search for <i>"'.$display_words.'"</i><hr />';
    
   // check if the search query returned any results
if ($result_count > 0){

	// display the header for the display table
	echo '<table class="search">';
	
	// loop though each of the results from the database and display them to the user
	while ($row = mysqli_fetch_assoc($query)){
		echo '<tr>
			<td><h3><a href="'.$row['url'].'">'.$row['title'].'</a></h3></td>
		</tr>
		<tr>
			<td>'.$row['blurb'].'</td>
		</tr>
		<tr>
			<td><i>'.$row['url'].'</i></td>
		</tr>';
	}
	
	// end the display of the table
	echo '</table>';
}
else
	echo 'There were no results for your search. Try searching for something else.';

    ?>




</body>

</html> 