<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\FAQ;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CmsController extends Controller
{
    public function index()
    {
        return view('admin.cms.index', [
            'counts' => [
                'banners' => Banner::count(),
                'services' => Service::count(),
                'blogs' => Blog::count(),
                'faqs' => FAQ::count(),
                'testimonials' => Testimonial::count(),
                'galleries' => Gallery::count(),
            ],
        ]);
    }

    // ---- Banners ----
    public function banners() { return view('admin.cms.banners.index', ['banners' => Banner::latest()->get()]); }
    public function bannerCreate() { return view('admin.cms.banners.form', ['banner' => new Banner()]); }
    public function bannerStore(Request $request)
    {
        $data = $request->validate(['title' => ['required'], 'subtitle' => ['nullable'], 'button_text' => ['nullable'], 'button_link' => ['nullable'], 'position' => ['nullable'], 'is_active' => ['sometimes', 'boolean']]);
        $banner = Banner::create($data);
        if ($request->hasFile('image')) {
            $banner->update(['image' => $request->file('image')->store('banners', 'public')]);
        }
        $this->log('create', 'cms', 'Banner ' . $banner->title . ' dibuat.', $banner);
        return redirect()->route('admin.cms.banners')->with('success', 'Banner dibuat.');
    }
    public function bannerEdit(Banner $banner) { return view('admin.cms.banners.form', compact('banner')); }
    public function bannerUpdate(Request $request, Banner $banner)
    {
        $data = $request->validate(['title' => ['required'], 'subtitle' => ['nullable'], 'button_text' => ['nullable'], 'button_link' => ['nullable'], 'position' => ['nullable'], 'is_active' => ['sometimes', 'boolean']]);
        if ($request->hasFile('image')) { $data['image'] = $request->file('image')->store('banners', 'public'); }
        $banner->update($data);
        $this->log('update', 'cms', 'Banner diperbarui.', $banner);
        return redirect()->route('admin.cms.banners')->with('success', 'Banner diperbarui.');
    }
    public function bannerDestroy(Banner $banner) { $this->log('delete', 'cms', 'Banner dihapus.', $banner); $banner->delete(); return back()->with('success', 'Banner dihapus.'); }

    // ---- Services ----
    public function services() { return view('admin.cms.services.index', ['services' => Service::all()]); }
    public function serviceCreate() { return view('admin.cms.services.form', ['service' => new Service()]); }
    public function serviceStore(Request $request)
    {
        $data = $request->validate(['name' => ['required'], 'icon' => ['nullable'], 'description' => ['nullable'], 'content' => ['nullable'], 'is_active' => ['sometimes', 'boolean']]);
        $service = Service::create(array_merge($data, ['slug' => Str::slug($data['name']) . '-' . Str::random(3)]));
        if ($request->hasFile('featured_image')) { $service->update(['featured_image' => $request->file('featured_image')->store('services', 'public')]); }
        $this->log('create', 'cms', 'Layanan ' . $service->name . ' dibuat.', $service);
        return redirect()->route('admin.cms.services')->with('success', 'Layanan dibuat.');
    }
    public function serviceEdit(Service $service) { return view('admin.cms.services.form', compact('service')); }
    public function serviceUpdate(Request $request, Service $service)
    {
        $data = $request->validate(['name' => ['required'], 'icon' => ['nullable'], 'description' => ['nullable'], 'content' => ['nullable'], 'is_active' => ['sometimes', 'boolean']]);
        if ($request->hasFile('featured_image')) { $data['featured_image'] = $request->file('featured_image')->store('services', 'public'); }
        $service->update($data);
        $this->log('update', 'cms', 'Layanan diperbarui.', $service);
        return redirect()->route('admin.cms.services')->with('success', 'Layanan diperbarui.');
    }
    public function serviceDestroy(Service $service) { $this->log('delete', 'cms', 'Layanan dihapus.', $service); $service->delete(); return back()->with('success', 'Layanan dihapus.'); }

    // ---- Blogs ----
    public function blogs() { return view('admin.cms.blogs.index', ['blogs' => Blog::latest()->get()]); }
    public function blogCreate() { return view('admin.cms.blogs.form', ['blog' => new Blog()]); }
    public function blogStore(Request $request)
    {
        $data = $request->validate(['title' => ['required'], 'content' => ['required'], 'excerpt' => ['nullable'], 'category' => ['nullable'], 'status' => ['required'], 'meta_title' => ['nullable'], 'meta_description' => ['nullable']]);
        $blog = Blog::create(array_merge($data, [
            'slug' => Str::slug($data['title']) . '-' . now()->timestamp,
            'author' => auth()->user()->name,
            'published_at' => $data['status'] === 'published' ? now() : null,
        ]));
        if ($request->hasFile('featured_image')) { $blog->update(['featured_image' => $request->file('featured_image')->store('blogs', 'public')]); }
        $this->log('create', 'cms', 'Artikel ' . $blog->title . ' dibuat.', $blog);
        return redirect()->route('admin.cms.blogs')->with('success', 'Artikel dibuat.');
    }
    public function blogEdit(Blog $blog) { return view('admin.cms.blogs.form', compact('blog')); }
    public function blogUpdate(Request $request, Blog $blog)
    {
        $data = $request->validate(['title' => ['required'], 'content' => ['required'], 'excerpt' => ['nullable'], 'category' => ['nullable'], 'author' => ['nullable'], 'status' => ['required'], 'meta_title' => ['nullable'], 'meta_description' => ['nullable']]);
        if ($request->hasFile('featured_image')) { $data['featured_image'] = $request->file('featured_image')->store('blogs', 'public'); }
        if ($data['status'] === 'published' && ! $blog->published_at) { $data['published_at'] = now(); }
        $blog->update($data);
        $this->log('update', 'cms', 'Artikel diperbarui.', $blog);
        return redirect()->route('admin.cms.blogs')->with('success', 'Artikel diperbarui.');
    }
    public function blogDestroy(Blog $blog) { $this->log('delete', 'cms', 'Artikel dihapus.', $blog); $blog->delete(); return back()->with('success', 'Artikel dihapus.'); }

    // ---- FAQs ----
    public function faqs() { return view('admin.cms.faqs.index', ['faqs' => FAQ::orderBy('sort_order')->get()]); }
    public function faqCreate() { return view('admin.cms.faqs.form', ['faq' => new FAQ()]); }
    public function faqStore(Request $request)
    {
        $data = $request->validate(['question' => ['required'], 'answer' => ['required'], 'sort_order' => ['nullable', 'integer'], 'is_active' => ['sometimes', 'boolean']]);
        $faq = FAQ::create($data);
        $this->log('create', 'cms', 'FAQ ditambahkan.', $faq);
        return redirect()->route('admin.cms.faqs')->with('success', 'FAQ ditambahkan.');
    }
    public function faqEdit(FAQ $faq) { return view('admin.cms.faqs.form', compact('faq')); }
    public function faqUpdate(Request $request, FAQ $faq)
    {
        $data = $request->validate(['question' => ['required'], 'answer' => ['required'], 'sort_order' => ['nullable', 'integer'], 'is_active' => ['sometimes', 'boolean']]);
        $faq->update($data);
        $this->log('update', 'cms', 'FAQ diperbarui.', $faq);
        return redirect()->route('admin.cms.faqs')->with('success', 'FAQ diperbarui.');
    }
    public function faqDestroy(FAQ $faq) { $this->log('delete', 'cms', 'FAQ dihapus.', $faq); $faq->delete(); return back()->with('success', 'FAQ dihapus.'); }

    // ---- Testimonials ----
    public function testimonials() { return view('admin.cms.testimonials.index', ['testimonials' => Testimonial::latest()->get()]); }
    public function testimonialCreate() { return view('admin.cms.testimonials.form', ['testimonial' => new Testimonial()]); }
    public function testimonialStore(Request $request)
    {
        $data = $request->validate(['customer_name' => ['required'], 'company' => ['nullable'], 'service_type' => ['nullable'], 'rating' => ['required', 'integer', 'min:1', 'max:5'], 'content' => ['required'], 'is_active' => ['sometimes', 'boolean']]);
        $t = Testimonial::create($data);
        if ($request->hasFile('photo')) { $t->update(['photo' => $request->file('photo')->store('testimonials', 'public')]); }
        $this->log('create', 'cms', 'Testimoni dari ' . $t->customer_name . ' dibuat.', $t);
        return redirect()->route('admin.cms.testimonials')->with('success', 'Testimoni dibuat.');
    }
    public function testimonialEdit(Testimonial $testimonial) { return view('admin.cms.testimonials.form', ['testimonial' => $testimonial]); }
    public function testimonialUpdate(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate(['customer_name' => ['required'], 'company' => ['nullable'], 'service_type' => ['nullable'], 'rating' => ['required', 'integer', 'min:1', 'max:5'], 'content' => ['required'], 'is_active' => ['sometimes', 'boolean']]);
        if ($request->hasFile('photo')) { $data['photo'] = $request->file('photo')->store('testimonials', 'public'); }
        $testimonial->update($data);
        $this->log('update', 'cms', 'Testimoni diperbarui.', $testimonial);
        return redirect()->route('admin.cms.testimonials')->with('success', 'Testimoni diperbarui.');
    }
    public function testimonialDestroy(Testimonial $testimonial) { $this->log('delete', 'cms', 'Testimoni dihapus.', $testimonial); $testimonial->delete(); return back()->with('success', 'Testimoni dihapus.'); }

    // ---- Galleries ----
    public function galleries() { return view('admin.cms.galleries.index', ['galleries' => Gallery::latest()->get()]); }
    public function galleryCreate() { return view('admin.cms.galleries.form', ['gallery' => new Gallery()]); }
    public function galleryStore(Request $request)
    {
        $data = $request->validate(['title' => ['nullable'], 'category' => ['nullable'], 'image' => ['required', 'image']]);
        $gallery = Gallery::create(['title' => $data['title'], 'category' => $data['category'] ?? 'umum', 'image' => $request->file('image')->store('galleries', 'public')]);
        $this->log('create', 'cms', 'Foto galeri ditambahkan.', $gallery);
        return redirect()->route('admin.cms.galleries')->with('success', 'Foto galeri ditambahkan.');
    }
    public function galleryEdit(Gallery $gallery) { return view('admin.cms.galleries.form', compact('gallery')); }
    public function galleryUpdate(Request $request, Gallery $gallery)
    {
        $data = $request->validate(['title' => ['nullable'], 'category' => ['nullable'], 'image' => ['nullable', 'image']]);
        if ($request->hasFile('image')) { $data['image'] = $request->file('image')->store('galleries', 'public'); }
        $gallery->update($data);
        $this->log('update', 'cms', 'Galeri diperbarui.', $gallery);
        return redirect()->route('admin.cms.galleries')->with('success', 'Galeri diperbarui.');
    }
    public function galleryDestroy(Gallery $gallery) { $this->log('delete', 'cms', 'Foto galeri dihapus.', $gallery); $gallery->delete(); return back()->with('success', 'Foto galeri dihapus.'); }
}