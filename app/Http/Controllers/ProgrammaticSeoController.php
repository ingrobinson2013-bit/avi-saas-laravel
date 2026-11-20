<?php

namespace App\Http\Controllers;

use App\Services\ProgrammaticSeoService;
use Illuminate\Http\Request;

class ProgrammaticSeoController extends Controller
{
    public function hub()
    {
        return view('seo.hub', [
            'symptoms' => ProgrammaticSeoService::getSymptoms(),
            'breeds' => ProgrammaticSeoService::getBreeds(),
            'cityProblems' => ProgrammaticSeoService::getCityProblems(),
            'bioLabCities' => ProgrammaticSeoService::getBioLabCities(),
            'saasCities' => ProgrammaticSeoService::getSaasCities(),
            'canonicalUrl' => 'https://avipetapp.com/salud-mascotas',
        ]);
    }

    public function showBioLabBreed(string $problema, string $raza)
    {
        $data = ProgrammaticSeoService::resolveBioLabBreed($problema, $raza);
        if (!$data) {
            abort(404);
        }

        $slug = "{$problema}-en-{$raza}";
        $canonicalUrl = "https://avipetapp.com/salud-mascotas/{$slug}";
        $ctaUrl = "https://biolab.avipetapp.com/dermo-gut-superboost?utm_source=seo&utm_medium=programmatic&utm_campaign={$slug}";

        return view('seo.biolab_programmatic', array_merge($data, [
            'slug' => $slug,
            'canonicalUrl' => $canonicalUrl,
            'ctaUrl' => $ctaUrl,
        ]));
    }

    public function showBioLabCity(string $problema, string $ciudad)
    {
        $data = ProgrammaticSeoService::resolveBioLabCity($problema, $ciudad);
        if (!$data) {
            abort(404);
        }

        $slug = "{$problema}-{$ciudad}";
        $canonicalUrl = "https://avipetapp.com/salud-mascotas/colombia/{$slug}";
        $ctaUrl = "https://biolab.avipetapp.com/dermo-gut-superboost?utm_source=seo&utm_medium=programmatic_city&utm_campaign={$slug}";

        return view('seo.biolab_programmatic', array_merge($data, [
            'slug' => $slug,
            'canonicalUrl' => $canonicalUrl,
            'ctaUrl' => $ctaUrl,
        ]));
    }

    public function showSaasCity(string $ciudad)
    {
        $data = ProgrammaticSeoService::resolveSaasCity($ciudad);
        if (!$data) {
            abort(404);
        }

        $canonicalUrl = "https://avipetapp.com/software-veterinario/{$ciudad}";

        return view('seo.saas_city', array_merge($data, [
            'canonicalUrl' => $canonicalUrl,
        ]));
    }
}
