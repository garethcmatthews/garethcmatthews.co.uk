<h3 class="pb-2 border-bottom">Technologies</h3>
<p>Listed below are the technologies and tools that I have used over the years and continue to use today.</p>
<p>Sections marked 'Secondary Skills' are products/tools that either I have little commercial experience of, or my knowledge of them has wained over the years through lack of use.</p>
<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4 py-4">
    <div class="col d-flex align-items-start">
        <img src="{{ url('img/icons/globe.svg') }}" class="technology me-3" />
        <div>
            <h4 class="fw-bold mb-0">Web Development</h4>
            <p class="skill-level">Primary Skills</p>
            <ul class="technology">
                @foreach ($technologies['web-development'][0]['items'] as $technology)
                    @if ($technology['primary'] === 1)<li><a href="{{ $technology['url'] }}" target="_blank">{{ $technology['title'] }}</a></li>@endif
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col d-flex align-items-start">
        <img src="{{ url('img/icons/globe.svg') }}" class="technology me-3" />
        <div>
            <h4 class="fw-bold mb-0">Web Development</h4>
            <p class="skill-level">Secondary Skills</p>
            <ul class="technology">
                @foreach ($technologies['web-development'][0]['items'] as $technology)
                    @if ($technology['primary'] === 0)<li><a href="{{ $technology['url'] }}" target="_blank">{{ $technology['title'] }}</a></li>@endif
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col d-flex align-items-start">
        <img src="{{ url('img/icons/tools.svg') }}" class="technology me-3" />
        <div>
            <h4 class="fw-bold mb-0">Tools</h4>
            <p class="skill-level">&nbsp;</p>
            <ul class="technology">
                @foreach ($technologies['tools'][0]['items'] as $technology)
                    <li><a href="{{ $technology['url'] }}" target="_blank">{{ $technology['title'] }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col d-flex align-items-start">
        <img src="{{ url('img/icons/puzzle-fill.svg') }}" class="technology me-3" />
        <div>
            <h4 class="fw-bold mb-0">Frameworks/CMS</h4>
            <p class="skill-level">Primary Skills</p>
            <ul class="technology">
                @foreach ($technologies['web-frameworks'][0]['items'] as $technology)
                    @if ($technology['primary'] === 1)<li><a href="{{ $technology['url'] }}" target="_blank">{{ $technology['title'] }}</a></li>@endif
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col d-flex align-items-start">
        <img src="{{ url('img/icons/puzzle-fill.svg') }}" class="technology me-3" />
        <div>
            <h4 class="fw-bold mb-0">Frameworks/CMS</h4>
            <p class="skill-level">Secondary Skills</p>
            <ul class="technology">
                @foreach ($technologies['web-frameworks'][0]['items'] as $technology)
                    @if ($technology['primary'] === 0)<li><a href="{{ $technology['url'] }}" target="_blank">{{ $technology['title'] }}</a></li>@endif
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col d-flex align-items-start">
        <img src="{{ url('img/icons/cpu.svg') }}" class="technology me-3" />
        <div>
            <h4 class="fw-bold mb-0">Third Party Apis</h4>
            <p class="skill-level">&nbsp;</p>
            <ul class="technology">
                @foreach ($technologies['tools-api'][0]['items'] as $technology)
                    <li><a href="{{ $technology['url'] }}" target="_blank">{{ $technology['title'] }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col d-flex align-items-start">
        <img src="{{ url('img/icons/github.svg') }}" class="technology me-3" />
        <div>
            <h4 class="fw-bold mb-0">VCS/Code Quality</h4>
            <ul class="technology">
                @foreach ($technologies['source-control'][0]['items'] as $technology)
                    <li><a href="{{ $technology['url'] }}" target="_blank">{{ $technology['title'] }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col d-flex align-items-start">
        <img src="{{ url('img/icons/diagram-3.svg') }}" class="technology me-3" />
        <div>
            <h4 class="fw-bold mb-0">Project Workflows</h4>
            <ul class="technology">
                @foreach ($technologies['project-management'][0]['items'] as $technology)
                    <li><a href="{{ $technology['url'] }}" target="_blank">{{ $technology['title'] }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col d-flex align-items-start">
        <img src="{{ url('img/icons/phone-vibrate-fill.svg') }}" class="technology me-3" />
        <div>
            <h4 class="fw-bold mb-0">Mobile</h4>
            <ul class="technology">
                @foreach ($technologies['mobile'][0]['items'] as $technology)
                    <li><a href="{{ $technology['url'] }}" target="_blank">{{ $technology['title'] }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col d-flex align-items-start">
        <img src="{{ url('img/icons/compass-fill.svg') }}" class="technology me-3" />
        <div>
            <h4 class="fw-bold mb-0">The Future</h4>
            <p class="skill-level">Things to learn when time allows</p>
            <ul class="technology">
                @foreach ($technologies['the-future'][0]['items'] as $technology)
                    <li><a href="{{ $technology['url'] }}" target="_blank">{{ $technology['title'] }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
