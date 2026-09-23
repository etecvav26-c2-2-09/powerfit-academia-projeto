<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PowerFit Academia - Treine na Melhor</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Header / Menu Responsivo -->
    <header class="navbar">
        <div class="logo">Power<span>Fit</span></div>
        <button class="menu-toggle" id="menu-btn" aria-label="Abrir Menu">☰</button>
        <nav class="nav-links" id="nav-menu">
            <a href="#home">Home</a>
            <a href="#modalidades">Modalidades</a>
            <a href="#planos">Planos</a>
            <a href="#contato">Contato</a>
        </nav>
    </header>

    <!-- Seção Home / Hero -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1>SUA EVOLUÇÃO COMEÇA AQUI</h1>
            <p>A academia com a melhor infraestrutura, ambiente exclusivo e foco nos seus resultados reais.</p>
            <a href="https://wa.me/5511999998888" target="_blank" class="btn-cta">MATRICULE-SE AGORA</a>
        </div>
    </section>

    <!-- Seção Modalidades -->
    <section id="modalidades" class="section-padding">
        <h2 class="section-title">NOSSAS MODALIDADES</h2>
        <div class="grid-container">
            <div class="card">
                <h3>Musculação</h3>
                <p>Equipamentos modernos de ponta e professores prontos para montar sua ficha de treino ideal.</p>
            </div>
            <div class="card">
                <h3>Crossfit</h3>
                <p>Treinos de alta intensidade para quem busca superar limites todos os dias.</p>
            </div>
            <div class="card">
                <h3>Ritmos & Dança</h3>
                <p>Queime calorias se divertindo com as melhores coreografias e músicas do momento.</p>
            </div>
        </div>
    </section>

    <!-- Seção Planos -->
    <section id="planos" class="section-padding bg-alt">
        <h2 class="section-title">NOSSOS PLANOS</h2>
        <div class="grid-container">
            <div class="card card-price">
                <h3>Plano Mensal</h3>
                <div class="price">R$ 119<span>/mês</span></div>
                <p>Acesso livre à musculação. Sem fidelidade.</p>
                <a href="#" class="btn-card">Escolher</a>
            </div>
            <div class="card card-price featured">
                <div class="badge">MAIS POPULAR</div>
                <h3>Plano Anual</h3>
                <div class="price">R$ 79<span>/mês</span></div>
                <p>Acesso total a todas as modalidades + avaliação física inclusa.</p>
                <a href="#" class="btn-card">Escolher</a>
            </div>
            <div class="card card-price">
                <h3>Plano Semestral</h3>
                <div class="price">R$ 99<span>/mês</span></div>
                <p>Acesso livre à musculação e área de cardio.</p>
                <a href="#" class="btn-card">Escolher</a>
            </div>
        </div>
    </section>

    <!-- Seção Contato -->
    <section id="contato" class="section-padding">
        <h2 class="section-title">FALE CONOSCO</h2>
        <div class="contact-wrapper">
            <div class="contact-info">
                <p><strong>📍 Endereço:</strong> Av. do Movimento, 500 - Centro</p>
                <p><strong>📞 WhatsApp:</strong> (11) 99999-8888</p>
                <p><strong>📧 E-mail:</strong> contato@powerfit.com.br</p>
                <p><strong>⏰ Horários:</strong> Seg a Sex: 06h às 23h | Sáb e Dom: 08h às 14h</p>
            </div>
        </div>
    </section>

    <!-- Botão Flutuante do WhatsApp -->
    <a href="https://wa.me/5511999998888" target="_blank" class="whatsapp-float">
        💬
    </a>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 PowerFit Academia. Desenvolvido Solo de forma Mobile First.</p>
    </footer>

    <script>
        // Script simples para abrir/fechar o menu hambúrguer no mobile
        const menuBtn = document.getElementById('menu-btn');
        const navMenu = document.getElementById('nav-menu');
        
        menuBtn.addEventListener('click', () => {
            navMenu.classList.toggle('active');
        });
    </script>
</body>
</html>
