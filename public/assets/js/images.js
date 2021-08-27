window.onload = () => {
    let links = document.querySelectorAll("[data-delete]");

    for(link of links) {
        link.addEventListener("click", function(e) {
            e.preventDefault();
            if(confirm("Voulez-vous supprimer cette image ?")) {
                //Send a ajax request to link's href with delete method
                fetch(this.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-type": "application/json"
                    },
                    body: JSON.stringify({"_token": this.dataset.token})
                }).then(
                    // Get the response in JSON
                    response => response.json()
                ).then(data => {
                    if(data.success) {
                        this.parentElement.remove()
                    } else {
                        alert(data.error)
                    }
                }).catch(e => alert(e))
            }
        })
    }
}