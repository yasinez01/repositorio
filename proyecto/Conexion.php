<?php   
    class Conexion{ 
        public $server;
        public $group;
        public $password;
        public $db_group;
        public $conexion;
        function __construct($server,$group,$password,$db_group){
            $this->server=$server;
            $this->group=$group;
            $this->password=$password;
            $this->db_group=$db_group;
            $this->conexion=mysqli_connect($this->server,$this->group,$this->password,$this->db_group);
            if (mysqli_connect_errno()){
                echo'<script type="text/javascript">
                alert("Fallo al conectar a MySQL '. mysqli_connect_error().'");
                window.location.href="loginregister.html";
                </script>';
            }
        }
        function validarUsuario($usuario, $pass){
            $consulta=$this->conexion->prepare("SELECT * FROM db_grupo28.usuario WHERE usuario=? and password=?");
            $consulta->bind_param('ss',$usuario,$pass);
            $consulta->execute();
            while($consulta->fetch()){
                return 1;
            }
            return 0;
        }
        function RegistrarUsuario($usuario,$pass){
            $consulta="INSERT INTO db_grupo28.usuario VALUES('$usuario','$pass')";
            $resultado=mysqli_query($this->conexion,$consulta);
            if($this->conexion->query($consulta)){
                echo'<script type="text/javascript">
                alert("Inserccion completa con exito");
                window.location.href="web.html";
                </script>';
            }else{
                echo'<script type="text/javascript">
                alert("Inserccion fallida");
                window.location.href="loginregister.html";
                </script>';
            }
            mysqli_free_result($resultado);
        }
        function cerrarSession(){
            mysqli_close($this->conexion);
        }
}