<?php

it('can access the home page', function () {
    $announcements = \App\Models\Announcement::factory()
        ->count(3)
        ->create();

    $this->get('/')
        ->assertStatus(200)
        ->assertSee(str()->limit($announcements[0]->title, 25, ''));
});

it('can access the donate page', function () {
    $this->get(route('donate'))
        ->assertStatus(200)
        ->assertSee('Give Online');
});

it('can access the online donation page', function () {
    $this->get(route('donate.online'))
        ->assertStatus(200)
        ->assertSee('Donate Online');
});

it('can access meet the about page', function () {
    $this->get(route('about'))
        ->assertStatus(200)
        ->assertSee('Our Mission');
});

it('can access meet the team page', function () {
    \App\Models\Team::factory()
        ->has(\App\Models\BoardMember::factory()->count(3))
        ->create([
            'name' => 'Board of Directors',
        ]);

    \App\Models\Team::factory()
        ->has(\App\Models\BoardMember::factory()->count(3))
        ->create([
            'name' => 'Management & Team Leadership',
        ]);

    $this->get(route('about.meet-the-team'))
        ->assertStatus(200)
        ->assertSee('Board of Directors')
        ->assertSee('Management & Team Leadership');
});

it('can access the partner page', function () {
    \App\Models\PartnerCategory::factory()
        ->has(\App\Models\Partner::factory()->count(3))
        ->create([
            'name' => 'Foundational Partners',
        ]);

    \App\Models\PartnerCategory::factory()
        ->has(\App\Models\Partner::factory()->count(3))
        ->create([
            'name' => 'Outreach Partners',
        ]);

    $this->get(route('about.partners'))
        ->assertStatus(200)
        ->assertSee('Foundational Partners')
        ->assertSee('Outreach Partners');
});

it('can access the editorial method page', function () {
    $this->get(route('about.editorial-method'))
        ->assertStatus(200)
        ->assertSee('Editorial Method');
});

it('can access the faqs page', function () {
    $project = \App\Models\Faq::factory()
        ->create([
            'question' => 'What is the purpose of the Wilford Woodruff Papers Project?',
            'category' => 'Project',
        ]);
    $documents = \App\Models\Faq::factory()
        ->create([
            'question' => 'What documents are included?',
            'category' => 'Documents',
        ]);
    $funding = \App\Models\Faq::factory()
        ->create([
            'question' => 'What is the Wilford Woodruff Papers Project budget?',
            'category' => 'Funding',
        ]);

    $this->get(route('about.frequently-asked-questions'))
        ->assertStatus(200)
        ->assertSee('Project')
        ->assertSee($project->question)
        ->assertSee($documents->question)
        ->assertSee($funding->question);
});

it('can access the contact us page', function () {
    $this->get(route('contact-us'))
        ->assertStatus(200)
        ->assertSee('First name');
});

it('can access the get involved page', function () {
    $this->get(route('get-involved.index'))
        ->assertStatus(200)
        ->assertSee('Get Involved');
});

it('can access the volunteer page', function () {
    $this->get(route('volunteer'))
        ->assertStatus(200)
        ->assertSee('Volunteer');
});

it('can access the internships page', function () {
    $internship = \App\Models\JobOpportunity::factory()
        ->create([
            'title' => 'Internship Opportunities',
        ]);
    $this->get(route('work-with-us.opportunity', ['opportunity' => $internship->slug]))
        ->assertStatus(200)
        ->assertSee('Internship Opportunities');
});

it('can access the career page', function () {
    $this->get(route('work-with-us'))
        ->assertStatus(200)
        ->assertSee('Job Opportunities');
});

it('can access the contribute documents page', function () {
    $this->get(route('contribute-documents'))
        ->assertStatus(200)
        ->assertSee('Contribute Documents');
});

it('can access the articles page', function () {
    $press = \App\Models\Article::factory()
        ->create();

    $this->get(route('media.articles'))
        ->assertStatus(200)
        ->assertSee('Articles')
        ->assertSee($press->title);
});

it('can access the article page', function () {
    $press = \App\Models\Article::factory()
        ->create();

    $this->get(route('media.article', ['article' => $press->slug]))
        ->assertStatus(200)
        ->assertSee($press->title);
});

it('can access the podcasts page', function () {
    $press = \App\Models\Podcast::factory()
        ->create();

    $this->get(route('media.podcasts'))
        ->assertStatus(200)
        ->assertSee('Podcasts')
        ->assertSee($press->title);
});

it('can access the podcast page', function () {
    $press = \App\Models\Podcast::factory()
        ->create();

    $this->get(route('media.podcast', ['podcast' => $press->slug]))
        ->assertStatus(200)
        ->assertSee($press->title);
});

it('can access the newsroom page', function () {
    $press = \App\Models\News::factory()
        ->create();

    $this->get(route('media.news'))
        ->assertStatus(200)
        ->assertSee('Newsroom')
        ->assertSee($press->title);
});

it('can access the photos page', function () {
    $photo = \App\Models\Photo::factory()
        ->create();

    $this->get(route('media.photos'))
        ->assertStatus(200)
        ->assertSee('Photos')
        ->assertSee($photo->title);
});

it('can access the photo page', function () {
    $photo = \App\Models\Photo::factory()
        ->create();

    $this->get(route('media.photos.show', ['photo' => $photo->uuid]))
        ->assertStatus(200)
        ->assertSee($photo->title);
});

it('can access the media kit page', function () {
    $this->get(route('media.kit'))
        ->assertStatus(200)
        ->assertSee('Media Kit');
});

it('can access the media requests page', function () {
    $this->get(route('media.requests'))
        ->assertStatus(200)
        ->assertSee('Media Requests');
});
