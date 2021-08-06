<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       <title>Acceuil</title>
        <link rel="stylesheet" href="{{asset('bootstrap.min.css')}}">
          <link rel="stylesheet" type="text/css" href="css/main.css">
        <link href="css/all.min.css" rel="stylesheet">
        <!--script src="{{asset('jquery-3.2.1.slim.min.js')}}"></script>
        <script src="{{asset('popper.min.js')}}"></script>
<script src="{{asset('bootstrap.min.js')}}"></script-->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 </head>
      <body>
  
  <div class="container">
  	  <div class="navbar">
        <table>
            <tr>
       <td> <a ><img src="css/lo.png" alt="" height="100" width="105" /></a> </td>
  	  </tr> 
       <tr class="r"><td><h4 >GESTION DES COURS</h4></td> </tr></table>
        </div>
        <table>
            <tr class="navbar-nav">
  	  	<nav class="dec">
  	  		<!-- Right Side Of Navbar -->
                    <ul>
            
  	  		             @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Authentification') }}</a>
                            </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('S\'inscrire') }}</a>
                                </li>
                                  
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}<span class="caret"></span>
                                </a>

                                <div id="dropd" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Se déconnecter') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                                
                           
  	  			<!--li class="b1"><a href="/h"><i title="Deconnecter" class="fas fa-sign-out-alt"></i> Déconnecter</a></li-->
                         @endguest
  	  		</ul>
  	  	</nav>
        <br>

     
</tr>
  </div>
 

<tr>

      <div class="date" > 
       <?php 

$mytime = Carbon\Carbon::now();
echo $mytime-> toDateTimeString();

?>
</div></tr></table>

<div> 
<a href="Sliste"  type="button"><button class="button-3d">Salles</button></a>
<a href="Dliste" type="button"><button class="button-3d">Dépatements</button></a>
<a href="Pliste" type="button"><button class="button-3d">Professeurs</button></a>
<br><br>
<a href="Mliste" type="button"><button class="button-3d">Matières</button></a>
<a href="Fliste" type="button"><button class="button-3d">Filières</button></a>
<a href="Cliste" type="button"><button class="button-3d">Classes</button></a>
<br><br>
<a href="Gliste" type="button"><button class="button-3d">Groupes</button></a>
<a href="Nliste" type="button"><button class="button-3d">Niveaux</button></a>
<a href="Cyliste" type="button"><button class="button-3d">Cycles</button></a>
<br><br>

<a href="calendar" type="button"><button class="button-3d">Emploi du temps</button></a>
<a href="point" type="button"><button class="button-3d">Pointage</button></a>
</div>

   </body>                                                                                                                             
</html>