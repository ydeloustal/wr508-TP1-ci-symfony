import './styles/app.css';
import { add } from './math.js';

// Classe à champ privé, pour observer la transpilation vers une cible ancienne.
class Compteur {
    #total;

    constructor(depart) {
        this.#total = depart;
    }

    augmente(nombre) {
        this.#total = add(this.#total, nombre);
        return this;
    }

    get valeur() {
        return this.#total;
    }
}

const compteur = new Compteur(40).augmente(2);

document.addEventListener('DOMContentLoaded', () => {
    const cible = document.querySelector('[data-total]');
    cible?.replaceChildren(String(compteur.valeur ?? 0));
});