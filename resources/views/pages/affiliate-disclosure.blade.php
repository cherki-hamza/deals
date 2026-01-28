@extends('layouts.app')

@section('title', 'Affiliate Disclosure - ' . config('app.name'))
@section('meta_description', 'Learn about our affiliate relationships and how we maintain transparency with our readers.')

@section('content')
    <section class="section bg-white">
        <div class="container-main">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-3xl lg:text-4xl font-bold font-heading text-warm-gray-900 mb-6">
                    Affiliate Disclosure
                </h1>

                <div class="prose prose-warm-gray max-w-none">
                    <p class="text-lg text-warm-gray-600 leading-relaxed">
                        We believe in complete transparency with our readers. This page explains how we earn money and
                        maintain our editorial integrity.
                    </p>

                    <h2>Amazon Associates Program</h2>
                    <p>
                        {{ config('app.name') }} is a participant in the <strong>Amazon Services LLC Associates
                            Program</strong>, an affiliate advertising program designed to provide a means for sites to earn
                        advertising fees by advertising and linking to Amazon.com.
                    </p>

                    <div class="bg-amber-accent-50 border-l-4 border-amber-accent-400 p-4 my-6">
                        <p class="text-warm-gray-700 mb-0">
                            <strong>What this means for you:</strong> When you click on product links on our site and make a
                            purchase on Amazon, we may earn a small commission. This comes at <strong>no additional cost to
                                you</strong> – the price you pay is the same whether you use our links or go directly to
                            Amazon.
                        </p>
                    </div>

                    <h2>How Affiliate Links Work</h2>
                    <ul>
                        <li>We include special tracking links when we recommend products</li>
                        <li>When you click these links and make a purchase, Amazon knows you came from our site</li>
                        <li>Amazon pays us a small percentage of your purchase as a referral fee</li>
                        <li>Your purchase price is exactly the same whether or not you use our links</li>
                    </ul>

                    <h2>Our Editorial Policy</h2>
                    <p>
                        The fact that we earn commissions does not influence our product recommendations. Our editorial
                        content is based on:
                    </p>
                    <ul>
                        <li>Thorough research and product analysis</li>
                        <li>Customer reviews and ratings</li>
                        <li>Product quality and value</li>
                        <li>Brand reputation and reliability</li>
                    </ul>
                    <p>
                        We recommend products because we believe they offer genuine value, not because we earn higher
                        commissions from them.
                    </p>

                    <h2>Why We Use Affiliate Links</h2>
                    <p>
                        Affiliate commissions help us:
                    </p>
                    <ul>
                        <li>Keep the website free for all users</li>
                        <li>Invest in better research and content</li>
                        <li>Maintain and improve the user experience</li>
                        <li>Cover hosting and operational costs</li>
                    </ul>

                    <h2>FTC Compliance</h2>
                    <p>
                        In accordance with the Federal Trade Commission's guidelines, we disclose that we have affiliate
                        relationships with the products and services we recommend. We are committed to honest and
                        transparent communication with our readers.
                    </p>

                    <h2>Questions?</h2>
                    <p>
                        If you have any questions about our affiliate relationships or this disclosure, please <a
                            href="{{ route('pages.contact') }}">contact us</a>.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection