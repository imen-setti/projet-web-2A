from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
import time
import pytesseract
from PIL import Image
import io
import base64

def test_registration():
    # Configuration du driver
    driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()))
    
    try:
        # Accéder à la page d'accueil
        driver.get("http://localhost/projetw22222/View/front/index.php")
        
        # Attendre que le bouton "Join Now" soit cliquable
        join_now_button = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.LINK_TEXT, "Join Now"))
        )
        join_now_button.click()
        
        # Attendre que le formulaire soit visible
        WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.ID, "registerForm"))
        )
        
        # Récupérer le code CAPTCHA depuis le canvas
        canvas = driver.find_element(By.ID, "captcha-canvas")
        canvas_base64 = driver.execute_script("return arguments[0].toDataURL('image/png').substring(21);", canvas)
        canvas_png = base64.b64decode(canvas_base64)
        image = Image.open(io.BytesIO(canvas_png))
        
        # Utiliser Tesseract pour lire le texte de l'image
        captcha_text = pytesseract.image_to_string(image).strip().upper()
        
        # Entrer le code CAPTCHA
        captcha_input = driver.find_element(By.ID, "captcha-input")
        captcha_input.send_keys(captcha_text)
        
        # Cliquer sur le bouton de vérification
        verify_button = driver.find_element(By.XPATH, "//button[text()='Vérifier']")
        verify_button.click()
        
        # Attendre que le formulaire d'inscription soit visible
        WebDriverWait(driver, 10).until(
            EC.visibility_of_element_located((By.ID, "registration-form"))
        )
        
        # Remplir le formulaire
        driver.find_element(By.ID, "nom").send_keys("Test")
        driver.find_element(By.ID, "prenom").send_keys("User")
        driver.find_element(By.ID, "email").send_keys("test@example.com")
        driver.find_element(By.ID, "password").send_keys("Test123!")
        driver.find_element(By.ID, "numtel").send_keys("+216 12345678")
        
        # Sélectionner le sexe
        sexe_select = driver.find_element(By.ID, "sexe")
        sexe_select.click()
        driver.find_element(By.XPATH, "//option[text()='Homme']").click()
        
        # Sélectionner le rôle
        role_select = driver.find_element(By.ID, "role")
        role_select.click()
        driver.find_element(By.XPATH, "//option[text()='Client']").click()
        
        # Soumettre le formulaire
        submit_button = driver.find_element(By.XPATH, "//button[@type='submit']")
        submit_button.click()
        
        # Attendre un peu pour voir le résultat
        time.sleep(3)
        
        # Vérifier si l'inscription a réussi
        success_message = driver.find_elements(By.CLASS_NAME, "alert-success")
        assert len(success_message) > 0, "L'inscription n'a pas réussi"
        
    finally:
        # Fermer le navigateur
        driver.quit()

if __name__ == "__main__":
    test_registration() 