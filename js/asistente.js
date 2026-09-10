document.addEventListener("DOMContentLoaded", () => {

    const botonIA = document.getElementById("botonIA");
    const ventanaIA = document.getElementById("ventanaIA");
    const cerrarIA = document.getElementById("cerrarIA");
    const enviarIA = document.getElementById("enviarIA");
    const entradaIA = document.getElementById("entradaIA");
    const mensajesIA = document.getElementById("mensajesIA");

    
    botonIA.addEventListener("click", () => {
        ventanaIA.classList.toggle("oculto");
        entradaIA.focus();
    });

    
    cerrarIA.addEventListener("click", () => {
        ventanaIA.classList.add("oculto");
    });

    
    enviarIA.addEventListener("click", enviarMensaje);

    
    entradaIA.addEventListener("keydown", (event) => {
        if (event.key === "Enter") {
            enviarMensaje();
        }
    });

    function enviarMensaje() {

        const mensaje = entradaIA.value.trim();

        if (mensaje === "") {
            return;
        }

        
        agregarMensaje(mensaje, "usuario");

        entradaIA.value = "";

        
        const escribiendo = agregarMensaje(
            "DulceIA está pensando...",
            "ia"
        );

        fetch("ia/procesar.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "mensaje=" + encodeURIComponent(mensaje)
        })
        .then(response => response.text())
        .then(respuesta => {

            escribiendo.remove();

            agregarMensaje(respuesta, "ia");

        })
        .catch(error => {

            escribiendo.remove();

            agregarMensaje(
                "Lo siento 😔, ocurrió un problema. Inténtalo nuevamente.",
                "ia"
            );

            console.error(error);
        });
    }

    function agregarMensaje(texto, tipo) {

        const mensaje = document.createElement("div");

        mensaje.classList.add("mensaje", tipo);

        mensaje.textContent = texto;

        mensajesIA.appendChild(mensaje);

        mensajesIA.scrollTop = mensajesIA.scrollHeight;

        return mensaje;
    }

});