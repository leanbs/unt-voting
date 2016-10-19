<!DOCTYPE html>
<html lang="en">
<head>
 	<meta charset="UTF-8">
 	<title>Email</title>
</head>
<body>
	Dear partisipan, terimakasih telah berpartisipasi dalam voting online ini! <br><br>
	<br><br>
	Silahkan klik link dibawah ini agar voting yang anda berikan ke stan kesayangan anda menjadi valid <br>
	<a href="{{ url('activeVote/'. $vote_code) }}"><h3>>> Klik disini <<</h3></a>
	<br><br>
	atau anda juga bisa masukan kode berikut ini ke field yang telah disediakan 
	<h3>{{ $vote_code }}</h3>
	<br><br><br><br><br>
	Terimakasih, Entrepreneurship Week UNTAR 9<br><br>	
</body>
</html>
