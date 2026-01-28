@extends('layouts.app')

@section('title', 'About Us - ' . config('app.name'))
@section('meta_description', 'Learn about our mission to help you find the best products. We provide expert reviews and curated recommendations.')

@section('content')
    <section class="section bg-white">
        <div class="container-main">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-3xl lg:text-4xl font-bold font-heading text-warm-gray-900 mb-6">
                    About Us
                </h1>

                <div class="prose prose-warm-gray max-w-none">
                    <p class="text-lg text-warm-gray-600 leading-relaxed">
                        Welcome to {{ config('app.name') }}! We're passionate about helping you discover the best products
                        and make informed purchasing decisions.
                    </p>

                    <h2>Our Mission</h2>
                    <p>
                        Our mission is simple: to cut through the noise and bring you carefully curated product
                        recommendations that actually matter. We spend countless hours researching, comparing, and testing
                        products so you don't have to.
                    </p>

                    <h2>What We Do</h2>
                    <p>
                        We scour the marketplace to find the best products across various categories. Our team evaluates
                        products based on:
                    </p>
                    <ul>
                        <li><strong>Quality</strong> - We only recommend products that meet high standards</li>
                        <li><strong>Value</strong> - Great products at fair prices</li>
                        <li><strong>Reviews</strong> - Real feedback from verified buyers</li>
                        <li><strong>Reliability</strong> - Products from trusted brands and sellers</li>
                    </ul>

                    <h2>How We Make Money</h2>
                    <p>
                        {{ config('app.name') }} is a participant in the Amazon Services LLC Associates Program, an
                        affiliate advertising program designed to provide a means for sites to earn advertising fees by
                        advertising and linking to Amazon.com.
                    </p>
                    <p>
                        When you click on product links and make a purchase, we may earn a small commission at no extra cost
                        to you. This helps us keep the site running and continue providing free content.
                    </p>

                    <h2>Contact Us</h2>
                    <p>
                        Have questions, suggestions, or feedback? We'd love to hear from you! Visit our <a
                            href="{{ route('pages.contact') }}">contact page</a> to get in touch.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection