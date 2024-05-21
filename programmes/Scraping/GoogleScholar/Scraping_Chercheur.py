# -*- coding: utf-8 -*-
"""
Created on Fri Feb 16 16:41:04 2024

@author: xizhi
"""

#####   cd C:\Users\xizhi\Downloads\Recherche_IDU_23_26\Scraping_chercheur
#####   data = scraping_Chercheur("https://scholar.google.com/citations?hl=fr&user=Eh72wrkAAAAJ&cstart=0&pagesize=1000000")


###############################################################################
# Bibliothèque
###############################################################################
import time
import random
from csv import *
import csv
import json
import os
import re

from fake_useragent import UserAgent

from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By

from datetime import datetime

#from fastapi import FastAPI

from bs4 import BeautifulSoup as bs


import Enreg_Chercheur

###############################################################################
# Configuration anti-bots : User-Agent, Selenium, ...
###############################################################################

def scraping_Chercheur(link):

    liste_dico = []

    # Contrer les anti-bots
    # Générer un User-Agent aléatoire
    ua = UserAgent()
    user_agent = ua.random

    # Configuration des options du navigateur Chrome
    chrome_options = Options()
    chrome_options.add_argument(f'user-agent={user_agent}')

    # Si tu ne veux pas afficher chrome
    #chrome_options.add_argument("--headless")  # Exécuter Chrome en mode headless (sans interface graphique)

    ###############################################################################
    # Première Scrapping sur la page principale Google Scholar
    ###############################################################################
    # Charger la page Google Scholar avec Selenium
    driver = webdriver.Chrome(options=chrome_options)
    driver.get(link)


    time.sleep(random.uniform(1, 5))
    # Extraire le HTML de la page
    html = driver.page_source

    # Analyser le HTML avec BeautifulSoup
    soup = bs(html, "html.parser")

    # Titre et lien
    titres = []
    hrefs = []
    for a in soup.find_all("a", {"class": "gsc_a_at"}):
        titres.append (a.text);
        if "scholar.google.fr" in a.get("href"):
            hrefs.append( a.get("href"))
        else :
            hrefs.append("https://scholar.google.fr" + a.get("href"))

    for titre in titres :
        dico = {}
        dico["titre"] = titre
        liste_dico.append(dico)

    for i in range (len(hrefs)) :
        liste_dico[i]["lien_page"] = hrefs[i]

    # Lien Citation
    i = 0
    liens_citations = []

    for citation in soup.find_all("a", {"class": "gsc_a_ac gs_ibl"}):
        if "scholar.google" in citation.get("href") :
            liens_citations.append(citation.get("href"))
        else :
            liens_citations.append("https://scholar.google.com" +citation.get("href"))
        i = i + 1


    for i in range (len(liens_citations)):
        liste_dico[i]["lien_citation"] = liens_citations[i]

    # # Contrer les anti-bots
    # time.sleep(10)
    time.sleep(random.uniform(1, 5))

    # Fermer le navigateur Selenium
    driver.quit()

    ###############################################################################
    # Scraping article et pdf de chaque ligne de la page principale
    ###############################################################################

        ###############################################################################
    def scrapping_article_pdf (lien):
        # Générer un User-Agent aléatoire
        ua = UserAgent()
        user_agent = ua.random

        # Configuration des options du navigateur Chrome
        chrome_options = Options()
        chrome_options.add_argument(f'user-agent={user_agent}')

        # Si tu ne veux pas afficher chrome
        #chrome_options.add_argument("--headless")  # Exécuter Chrome en mode headless (sans interface graphique)

        ###############################################################################
        # Première Scrapping sur la page principale Google Scholar
        ###############################################################################
        # Charger la page Google Scholar avec Selenium
        driver = webdriver.Chrome(options=chrome_options)
        driver.get(lien);

        # Extraire le HTML de la page
        html = driver.page_source

        # Analyser le HTML avec BeautifulSoup
        soup = bs(html, "html.parser")

        # Anti-bots
        time.sleep(random.uniform(1, 3))

        # Recup
        data = []

        # Mise en place vides
        data.append("")
        data.append("")
        data.append("")
        data.append("")
        data.append("")
        data.append("")
        data.append("")

        # Une liste des types de publication
        types_de_publication = ["Revue","Conférence","Livre","Chapitre de livre","Thèse","Mémoire","Rapport technique","Prépublication","Article de presse","Communication personnelle"]


        # Indices
        indice_auteur = -1
        indice_date = -1
        indice_type_titre = -1
        indice_edit = -1
        indice_desc = -1
        indice_pages = -1

        # Phase 1 : Analyse de la page
        i = 0
        for recherche in soup.find_all("div", class_="gsc_oci_field"):

            if (recherche.text == "Auteurs") :
                indice_auteur = i
            if (recherche.text == "Date de publication"):
                indice_date = i
            if (recherche.text in types_de_publication):
                indice_type_titre = i
                data[3] = recherche.text
            if (recherche.text == "Éditeur"):
                indice_edit = i
            if (recherche.text == "Description") :
                indice_desc = i
            if (recherche.text == "Pages"):
                indice_pages = i

            i = i + 1


        # Phase 2 : Complète les données
        i= 0
        for recherche in soup.find_all("div", class_="gsc_oci_value"):

            # Auteurs
            if (i == indice_auteur):
                noms = recherche.text
                liste_noms = [nom.strip() for nom in noms.split(',')]
                data[0] = liste_noms

            # Dates
            if (i == indice_date):
                date = recherche.text
                def verifier_format_date_sans_jour(date_str):
                    pattern = r'^\d{4}/\d{1,2}$'
                    if re.match(pattern, date_str):
                        return True
                    else:
                        return False

                def verifier_format_date_avec_jour(date_str):
                    pattern = r'^\d{4}/\d{1,2}/\d{1,2}$'
                    if re.match(pattern, date_str):
                        return True
                    else:
                        return False
                if verifier_format_date_sans_jour(date):
                    date_obj = datetime.strptime(date, '%Y/%m')
                    data[1] = date_obj.strftime('%Y-%m-%d')
                elif verifier_format_date_avec_jour(date):
                    date_obj = datetime.strptime(date, '%Y/%m/%d')
                    data[1] = date_obj.strftime('%Y-%m-%d')
                else:
                    date_obj = datetime.strptime(date, '%Y')
                    data[1] = date_obj.strftime('%Y-%m-%d')


            # titre du type
            if (i == indice_type_titre):
                data[2] = recherche.text

            # Editeurs
            if (i == indice_edit):
                data[4] = recherche.text

            # Description
            if (i == indice_desc):
                data[5] = recherche.text

            # Pages
            if (i == indice_pages):
                data[6] = recherche.text

            # Ajout du compteur
            i = i + 1


        # Lien article et lien pdf
        i = 0

        for citation in driver.find_elements(By.XPATH, '//div[@id="gsc_oci_title_wrapper"]'):
            pack = citation.find_elements(By.TAG_NAME, "a")
            # [lien article ,lien pdf]
            if len(pack) > 1:
                data.append([pack[1].get_attribute("href"), pack[0].get_attribute("href")])
            elif len(pack) == 1 and "pdf" in pack[0].get_attribute("href") :
                data.append(["", pack[0].get_attribute("href")])
            elif len(pack) == 1 :
                                data.append([ pack[0].get_attribute("href"),""])
            else :
                data.append(["",""])
            i = i + 1

        # Anti-bots
        time.sleep(random.uniform(1, 3))

        # Fermer le navigateur Selenium
        driver.quit()

        return data

    ###############################################################################

    i = 0
    for donnee in liste_dico:
        pack = scrapping_article_pdf(liste_dico[i]["lien_page"])
        liste_dico[i]["auteurs"] = pack[0]
        liste_dico[i]["date_de_publication"] = pack[1]
        liste_dico[i]["type_titre"] = pack[2]
        liste_dico[i]["type"] = pack[3]
        liste_dico[i]["editeurs"] = pack[4]
        liste_dico[i]["description"] = pack[5]
        liste_dico[i]["pages"] = pack[6]
        liste_dico[i]["lien_article"] = pack[7][0]
        liste_dico[i]["lien_pdf"] = pack[7][1]


        i = i + 1

    ###############################################################################
    # Enregistrement à JSON file ...
    ###############################################################################
    with open("Chercheur.json", "w", encoding="utf-8") as json_file:
        json.dump(liste_dico, json_file, ensure_ascii=False, indent=4)

    ###############################################################################
    # Scraping les citations de chaque ligne de la page principale (faut créer un dossier et faire une liste des csv)
    ###############################################################################

    # https://scholar.google.fr/scholar?start=0&hl=fr&as_sdt=2005& sciodt=0,5&cites=4650070807819840431&scipsc=
    # change la partie start={nb}
    return liste_dico
###############################################################################
# Récupération des données
###############################################################################


def scraping_all_authors():
    # Ouvrir le fichier JSON en mode lecture
    with open("Auteurs.json", "r", encoding="utf-8") as fichier_json:
        # Charger le contenu du fichier JSON dans un objet Python
        data_auteur = json.load(fichier_json)

    for data_aut in data_auteur:
        scraping_Chercheur(data_aut)
        enreg_Chercheur()

# raceback (most recent call last):
#   File "<console>", line 1, in <module>
#   File "C:\Users\xizhi\Downloads\Recherche_IDU_23_26\Scraping_chercheur\Scraping_Chercheur.py", line 316, in scraping_all_authors
#     enreg_Chercheur()
#   File "C:\Users\xizhi\Downloads\Recherche_IDU_23_26\Scraping_chercheur\Enreg_Chercheur.py", line 52, in enreg_Chercheur
#     first_name, last_name = author.split(' ', 1)
# ValueError: not enough values to unpack (expected 2, got 1)
