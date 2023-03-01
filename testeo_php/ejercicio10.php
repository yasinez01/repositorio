<?php
/*Vamos a coger dos imágenes de Internet con un tamaño de 200x200 pixeles. 
Posteriormente vamos a realizar un script php que nos ponga en pantalla estas dos imágenes alternadas un total de 100 veces.*/ 

// URL de las imágenes
$img1_url = "https://media.istockphoto.com/id/831326662/es/foto/espacio-de-fondo-lente-abstracta-magia-flare.jpg?s=1024x1024&w=is&k=20&c=2M3xrb81sEY20RQEiyiTi0OyYvnGGw6S9L74I3JYZ6o=";
$img2_url = "https://media.istockphoto.com/id/1173458620/es/foto/rostro-humano-digital-abstracto.jpg?s=612x612&w=0&k=20&c=-AUVef2Nv3dDJwDIlYzvmixfPQZ7lmYLAssFv-H_syU=";

// Mostrar las imágenes alternadamente
for ($i = 1; $i <= 100; $i++) {
  if ($i % 2 == 0) {
    // Mostrar la segunda imagen
    echo "<img src='$img2_url' alt='Imagen 2' width='200' height='200'>";
  } else {
    // Mostrar la primera imagen
    echo "<img src='$img1_url' alt='Imagen 1' width='200' height='200'>";
  }
}
?>
