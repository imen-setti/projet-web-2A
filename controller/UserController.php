<?php
require_once __DIR__ . '/../config/connexion.php';
require_once __DIR__ . '/../model/User.php';


class UserController {

    
    public function ajouterUser(User $user) {
        $sql = "SELECT * FROM user WHERE email = :email";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->execute(['email' => $user->getEmail()]);
        
        if ($req->rowCount() > 0) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999; width: 300px;">
                    <strong>Erreur!</strong>User déjà inscrit, Cet email est déjà utilisé.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
            exit(); 
        }
    
        
        $sql = "INSERT INTO user (nom, prenom, email, password, numtel, sexe, role)
                VALUES (:nom, :prenom, :email, :password, :numtel, :sexe, :role)";
        
        $req = $db->prepare($sql);
        $req->execute([
            'nom'      => $user->getNom(),
            'prenom'   => $user->getPrenom(),
            'email'    => $user->getEmail(),
            'password' => $user->getPassword(),
            'numtel'   => $user->getNumtel(),
            'sexe'     => $user->getSexe(),
            'role'     => $user->getRole()
        ]);
        
        
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999; width: 300px;">
                <strong>Succès!</strong> Votre compte a été créé avec succès.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        
        
        echo '<script>
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 3000);
              </script>';
        exit(); 
    }
    

    
    public function afficherUsers() {
        $sql = "SELECT * FROM user";
        $db = config::getConnexion();
        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function supprimerUser($id) {
        try {
            $sql = "DELETE FROM user WHERE iduser = :id";
            $db = config::getConnexion();
            $req = $db->prepare($sql);
            $req->bindParam(':id', $id, PDO::PARAM_INT);
            $req->execute();

            
            if ($req->rowCount() > 0) {
                
                header('Location: dashboard.php?success=Utilisateur supprimé avec succès');
                exit;
            } else {
                
                header('Location: dashboard.php?error=Utilisateur non trouvé');
                exit;
            }
        } catch (Exception $e) {
            
            header('Location: dashboard.php?error=Erreur lors de la suppression');
            exit;
        }
    }


    
    public function modifierUser($id, User $user) {
        // Remarque : le champ password est ici laissé vide si vous ne souhaitez pas le modifier.
        // Vous pouvez adapter cette logique pour gérer la modification du mot de passe.
        $sql = "UPDATE user SET 
                    nom = :nom,
                    prenom = :prenom,
                    email = :email,
                    password = :password, 
                    numtel = :numtel,
                    sexe = :sexe,
                    role = :role
                WHERE iduser = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->execute([
            'id'     => $id,
            'nom'    => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'email'  => $user->getEmail(),
            'password'  => $user->getPassword(),
            'numtel' => $user->getNumtel(),
            'sexe'   => $user->getSexe(),
            'role'   => $user->getRole()
        ]);
    }

    
    public function update() {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
    
            $user = new User(
                $_POST['nom'],
                $_POST['prenom'],
                $_POST['email'],
                $_POST['password'], // Mot de passe non modifié ici
                $_POST['numtel'],
                $_POST['sexe'],
                $_POST['role']
            );
            $this->modifierUser($id, $user);
        }
        header('Location: dashboard.php');
        exit;
    }

    
    public function delete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->supprimerUser($id);
        } else {
            header('Location: dashboard.php?error=Aucun ID spécifié pour la suppression');
            exit;
        }
    }
    public function login() {
        // Traiter la connexion si le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Connexion à la base de données
            $db = config::getConnexion();
            $sql = "SELECT * FROM user WHERE email = :email";
            $stmt = $db->prepare($sql);
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Vérification du mot de passe
                if ($user['password'] === $password) {
                    // Connexion réussie
                    $_SESSION['user_id'] = $user['iduser'];  // Sauvegarde l'ID utilisateur dans la session
                    $_SESSION['user_email'] = $user['email'];  // Sauvegarde l'email dans la session
                    $_SESSION['message'] = 'Connexion réussie !';
                    header('Location: index.php');  // Redirige vers la page d'accueil
                    exit;
                } else {
                    // Mot de passe incorrect
                    $_SESSION['message'] = 'Mot de passe incorrect.';
                }
            } else {
                // Email non trouvé
                $_SESSION['message'] = 'Email non trouvé.';
            }
        }
    }
    
}

?>
