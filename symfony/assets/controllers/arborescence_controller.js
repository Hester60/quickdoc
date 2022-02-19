import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['treeviewCaret', 'treeviewLink', 'treeviewMain'];

    connect() {
        this.treeviewCaretTargets.map(elem => {
            elem.addEventListener("click", (event) => {
                this.toggleTreeviewElement(event.target);
            });
        });

        this.openParents(this.getActiveLink());
    }

    /**
     * Retourne le lien actif de l'arborescence
     *
     * @returns HTMLElement
     */
    getActiveLink() {
        return this.treeviewLinkTargets.find((e) => e.classList.contains('active'));
    }

    /**
     * Ouvre tous les parents d'un l'élément (ainsi que lui même)
     *
     * @param element
     */
    openParents(element) {
        while (element) {
            if (element.tagName.toLowerCase() === 'li') {
                let span = element.firstElementChild;
                if (span.classList.contains('treeview-caret')) {
                    this.toggleTreeviewElement(span);
                }
            }

            if (element === this.treeviewMainTarget) {
                break;
            }
            element = element.parentNode;
        }
    }

    /**
     * Ouvre l'élement passé en paramètre
     *
     * @param element
     */
    toggleTreeviewElement(element) {
        // Uniquement sur les span, afin d'éviter la fermeture lorsque l'utilisateur clique sur le lien
        if (element.tagName.toLowerCase() === 'span') {
            element.parentElement.querySelector(".treeview.nested").classList.toggle("active");
            element.classList.toggle("treeview-caret-down");
        }
    }
}
