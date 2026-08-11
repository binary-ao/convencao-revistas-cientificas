<footer class="site-footer py-5 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-6 col-lg-3">
                <div class="footer-heading">Convenção</div>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('about') }}">Sobre</a></li>
                    <li class="mb-2"><a href="{{ route('program') }}">Programa</a></li>
                    <li class="mb-2"><a href="{{ route('speakers.index') }}">Oradores</a></li>
                    <li class="mb-2"><a href="{{ route('news.index') }}">Notícias</a></li>
                    <li class="mb-2"><a href="{{ route('gallery.index') }}">Galeria</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-3">
                <div class="footer-heading">Participação</div>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('registration.create') }}">Inscrição</a></li>
                    <li class="mb-2"><a href="{{ route('workshops.index') }}">Workshops</a></li>
                    <li class="mb-2"><a href="{{ route('courses.index') }}">Cursos</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-3">
                <div class="footer-heading">Informações</div>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('faq') }}">FAQ</a></li>
                    <li class="mb-2"><a href="{{ route('documents.index') }}">Documentos</a></li>
                    <li class="mb-2"><a href="{{ route('registration.lookup') }}">Consultar Inscrição</a></li>
                    <li class="mb-2"><a href="{{ route('certificate.validate') }}">Validar Certificado</a></li>
                    <li class="mb-2"><a href="{{ route('contacts') }}">Contactos</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-3">
                <div class="footer-heading">Siga-nos</div>
                <p class="small mb-0">
                    Redes sociais oficiais a divulgar em breve.
                </p>
            </div>
        </div>

        <hr class="hr-thin">

        <div class="d-flex flex-wrap justify-content-between gap-2">
            <p class="small mb-0">
                &copy; {{ now()->year }} 1ª Convenção Nacional de Revistas Científicas Angolanas. Todos os direitos reservados.
            </p>
            <p class="small mb-0">
                <a href="{{ route('privacy') }}">Política de Privacidade</a>
                &bull;
                <a href="{{ route('terms') }}">Termos de Utilização</a>
            </p>
        </div>
    </div>
</footer>
