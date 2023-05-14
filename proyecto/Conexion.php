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
        function validarUsuario($usuario, $pass){//aplicamos el mecanismo prepared statement para evitar vulnerabilidades -> CWE-89:Improper Neutralization of Special Elements used in an SQL Command ('SQL Injection')
            $consulta=$this->conexion->prepare("SELECT * FROM db_grupo28.final_usuario WHERE usuario=? and password=?");
            $consulta->bind_param('ss',$usuario,$pass);
            $consulta->execute();
            while($consulta->fetch()){
                return 1;
            }
            return 0;
        }
        function validarUsuarioAdmin($usuario,$pass){
            $consulta="SELECT administrador FROM db_grupo28.final_usuario where  usuario='$usuario' and password='$pass'";
            $resultado=mysqli_query($this->conexion,$consulta);
            while($dato = mysqli_fetch_array($resultado)){
                return $dato['administrador'];
            }
            mysqli_free_result($resultado);
            return 0;
        }
        function RegistrarUsuario($usuario,$pass){
            $stmt = $this->conexion->prepare("INSERT INTO db_grupo28.final_usuario (usuario, password, administrador) VALUES (?, ?, 0)");
            $stmt->bind_param("ss", $usuario, $pass);
            if($stmt->execute()){
                echo'<script type="text/javascript">
                    alert("Inserccion completa con exito");
                    window.location.href="web.php";
                </script>';
            }else{
                echo'<script type="text/javascript">
                    alert("Inserccion fallida");
                    window.location.href="loginregister.html";
                </script>';
            }
            $stmt->close();
        }
        function cerrarSession(){
            mysqli_close($this->conexion);
        }
}