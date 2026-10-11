document.addEventListener("DOMContentLoaded", () => {

    const botonIA = document.getElementById("botonIA");
    const ventanaIA = document.getElementById("ventanaIA");
    const cerrarIA = document.getElementById("cerrarIA");
    const enviarIA = document.getElementById("enviarIA");
    const entradaIA = document.getElementById("entradaIA");
    const mensajesIA = document.getElementById("mensajesIA");

    
    cargarHistorial();

    botonIA.addEventListener("click", () => {
        ventanaIA.classList.toggle("oculto");
        entradaIA.focus();
        scrollToBottom();
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
        guardarEnHistorial(mensaje, "usuario");

        entradaIA.value = "";

        const escribiendo = agregarMensaje("DulceIA está pensando...", "ia");

        fetch("ia/procesar.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "mensaje=" + encodeURIComponent(mensaje)
        })
        .then(response => response.text())
        .then(respuesta => {
            if (escribiendo && escribiendo.parentNode) {
                escribiendo.remove();
            }

            agregarMensaje(respuesta, "ia");
            guardarEnHistorial(respuesta, "ia");
        })
        .catch(error => {
            if (escribiendo && escribiendo.parentNode) {
                escribiendo.remove();
            }

            const errorMsg = "Lo siento 😔, ocurrió un problema. Inténtalo nuevamente.";
            agregarMensaje(errorMsg, "ia");
            guardarEnHistorial(errorMsg, "ia");

            console.error(error);
        });
    }

    function agregarMensaje(texto, tipo) {
        const mensaje = document.createElement("div");
        mensaje.classList.add("mensaje", tipo);
        
        if (tipo === "ia") {
            mensaje.innerHTML = texto;
        } else {
            mensaje.textContent = texto;
        }

        mensajesIA.appendChild(mensaje);
        scrollToBottom();

        return mensaje;
    }

    function scrollToBottom() {
        mensajesIA.scrollTop = mensajesIA.scrollHeight;
    }

    function guardarEnHistorial(texto, tipo) {
        let historial = JSON.parse(sessionStorage.getItem("chat_dulceia")) || [];
        if (texto === "DulceIA está pensando...") return;
        historial.push({ texto, tipo });
        sessionStorage.setItem("chat_dulceia", JSON.stringify(historial));
    }

    function cargarHistorial() {
        let historial = JSON.parse(sessionStorage.getItem("chat_dulceia")) || [];
        
        if (historial.length === 0) return;

        
        if (mensajesIA.children.length <= 1) { 
            historial.forEach(item => {
                const mensaje = document.createElement("div");
                mensaje.classList.add("mensaje", item.tipo);
                if (item.tipo === "ia") {
                    mensaje.innerHTML = item.texto;
                } else {
                    mensaje.textContent = item.texto;
                }
                mensajesIA.appendChild(mensaje);
            });
            scrollToBottom();
        }
    }

    const observer = new MutationObserver((mutations) => {
        if (mensajesIA.children.length === 0) {
            let historial = JSON.parse(sessionStorage.getItem("chat_dulceia")) || [];
            if (historial.length > 0) {
                cargarHistorial();
            }
        }
    });

    observer.observe(mensajesIA, { childList: true });

});