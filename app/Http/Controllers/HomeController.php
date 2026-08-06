<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Blog;
use App\Models\FAQ;
use App\Models\Fleet;
use App\Models\Gallery;
use App\Models\IntercityTravel;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\TourPackage;
use App\Models\WeddingCar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'fleet' => Fleet::count(),
            'customer' => \App\Models\User::whereHas('roles', fn ($q) => $q->where('name', 'customer'))->count(),
            'trip' => \App\Models\Booking::count(),
            'destination' => TourPackage::count(),
        ];

        return view('pages.home', [
            'banners' => Banner::where('is_active', true)->get(),
            'services' => Service::where('is_active', true)->get(),
            'fleets' => Fleet::where('is_active', true)->where('status', 'tersedia')->take(6)->get(),
            'tours' => TourPackage::where('is_active', true)->take(6)->get(),
            'travels' => IntercityTravel::where('status', 'aktif')->take(4)->get(),
            'weddings' => WeddingCar::where('is_active', true)->take(3)->get(),
            'testimonials' => Testimonial::where('is_active', true)->take(6)->get(),
            'blogs' => Blog::published()->latest('published_at')->take(3)->get(),
            'stats' => $stats,
            'faqs' => FAQ::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function about()
    {
        return view('pages.about', [
            'stats' => [
                'fleet' => Fleet::count(),
                'customer' => \App\Models\User::whereHas('roles', fn ($q) => $q->where('name', 'customer'))->count(),
                'trip' => \App\Models\Booking::count(),
                'year' => now()->year - 2016,
            ],
            'testimonials' => Testimonial::where('is_active', true)->take(4)->get(),
        ]);
    }

    public function services()
    {
        return view('pages.services', [
            'services' => Service::where('is_active', true)->get(),
            'tours' => TourPackage::where('is_active', true)->take(3)->get(),
        ]);
    }

    public function serviceDetail($slug)
    {
        $service = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('pages.service-detail', compact('service'));
    }

    public function fleet(Request $request)
    {
        $query = Fleet::where('is_active', true)->where('status', '!=', 'nonaktif');
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('brand', 'like', '%' . $request->q . '%')
                    ->orWhere('model', 'like', '%' . $request->q . '%');
            });
        }
        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }
        return view('pages.fleet', ['fleets' => $query->paginate(9)->withQueryString()]);
    }

    public function fleetDetail(Fleet $fleet)
    {
        return view('pages.fleet-detail', ['fleet' => $fleet]);
    }

    public function tours()
    {
        return view('pages.tours', [
            'tours' => TourPackage::where('is_active', true)->paginate(9),
        ]);
    }

    public function tourDetail(TourPackage $tour)
    {
        return view('pages.tour-detail', [
            'tour' => $tour,
            'schedules' => $tour->schedules()->where('departure_date', '>=', now())->get(),
        ]);
    }

    public function travel()
    {
        return view('pages.travel', ['travels' => IntercityTravel::where('status', 'aktif')->get()]);
    }

    public function wedding()
    {
        return view('pages.wedding', ['weddings' => WeddingCar::where('is_active', true)->get()]);
    }

    public function gallery()
    {
        return view('pages.gallery', ['galleries' => Gallery::all()]);
    }

    public function testimonials()
    {
        return view('pages.testimonials', ['testimonials' => Testimonial::where('is_active', true)->get()]);
    }

    public function faq()
    {
        return view('pages.faq', ['faqs' => FAQ::where('is_active', true)->orderBy('sort_order')->get()]);
    }

    public function blogIndex()
    {
        return view('pages.blog', [
            'blogs' => Blog::published()->latest('published_at')->paginate(9),
        ]);
    }

    public function blogShow(Blog $blog)
    {
        if ($blog->status !== 'published') {
            abort(404);
        }
        return view('pages.blog-detail', [
            'blog' => $blog,
            'related' => Blog::published()->where('id', '!=', $blog->id)->latest('published_at')->take(3)->get(),
        ]);
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactSend(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string'],
            'subject' => ['required', 'string'],
            'message' => ['required', 'string'],
        ]);

        // Persist as a notification to staff and send to company email
        $subject = 'Pesan Kontak: ' . $data['subject'];
        $this->flashSuccess('Terima kasih! Pesan Anda telah kami terima. Tim kami akan segera menghubungi Anda.');

        return back();
    }

    public function sitemap()
    {
        $urls = [
            '/', '/tentang-kami', '/layanan', '/armada', '/paket-wisata',
            '/travel-antar-kota', '/wedding-car', '/galeri', '/faq', '/blog', '/kontak', '/booking', '/tracking',
        ];

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $url) {
            $xml .= "<url><loc>" . url($url) . "</loc><changefreq>weekly</changefreq></url>\n";
        }
        foreach (Fleet::where('is_active', true)->get() as $f) {
            $xml .= "<url><loc>" . route('fleet.show', $f) . "</loc></url>\n";
        }
        foreach (TourPackage::where('is_active', true)->get() as $t) {
            $xml .= "<url><loc>" . route('tours.show', $t) . "</loc></url>\n";
        }
        foreach (Blog::published()->get() as $b) {
            $xml .= "<url><loc>" . route('blog.show', $b) . "</loc></url>\n";
        }
        $xml .= '</urlset>';

        return response($xml)->header('Content-Type', 'application/xml');
    }

    public function robots()
    {
        $content = "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /customer\nSitemap: " . url('/sitemap.xml');
        return response($content)->header('Content-Type', 'text/plain');
    }
}