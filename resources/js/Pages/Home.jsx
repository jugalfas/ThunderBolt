import { Head, Link, usePage } from "@inertiajs/react";
import {
    Card,
    CardBody,
    CardHeader,
    Typography,
    Button,
    IconButton,
    Input,
    Textarea,
    Checkbox,
} from "@material-tailwind/react";
import { FingerPrintIcon, UsersIcon } from "@heroicons/react/24/solid";
import { PageTitle, Footer, Navbar } from "@/widgets/layout";
import { FeatureCard, PostCard } from "@/widgets/cards";
import { featuresData, teamData, contactData } from "@/data";
import React from "react";
import "../../css/tailwind.min.css";

export default function Home(data) {
    const site_name = import.meta.env.VITE_APP_NAME;
    const posts = data.posts;
    return (
        <>
            <Head title="Home" />
            <div className="container absolute left-2/4 z-10 mx-auto -translate-x-2/4 p-4">
                <Navbar />
            </div>
            <div className="relative flex h-screen content-center items-center justify-center pt-16 pb-32">
                <div className="absolute top-0 h-full w-full bg-[url('/images/background-3.png')] bg-cover bg-center" />
                <div className="absolute top-0 h-full w-full bg-black/60 bg-cover bg-center" />
                <div className="max-w-8xl container relative mx-auto">
                    <div className="flex flex-wrap items-center">
                        <div className="ml-auto mr-auto w-full px-4 text-center">
                            <Typography
                                variant="h1"
                                color="white"
                                className="mb-6 font-black"
                            >
                                Stay Motivated, Stay Focused, Stay Unstoppable.
                            </Typography>
                            <Typography
                                variant="lead"
                                color="white"
                                className="opacity-80"
                            >
                                Welcome to {site_name}, your ultimate
                                destination for personal growth and motivation.
                                Whether you're looking to improve your mindset,
                                boost your productivity, or stay motivated
                                through life’s challenges, we’re here to guide
                                you every step of the way. Our practical tips,
                                inspirational stories, and actionable advice
                                will help you unlock your full potential and
                                achieve success, no matter where you are in the
                                world. Start your transformation today!
                            </Typography>
                        </div>
                    </div>
                </div>
            </div>
            <section className="-mt-32 bg-white px-4 pb-20 pt-4">
                <div className="container mx-auto">
                    <div className="mt-32 flex flex-wrap items-center">
                        <div className="mx-auto -mt-8 w-full px-4 md:w-5/12">
                            <div className="mb-6 inline-flex h-16 w-16 items-center justify-center rounded-full bg-blue-gray-900 p-2 text-center shadow-lg">
                                <FingerPrintIcon className="h-8 w-8 text-white " />
                            </div>
                            <Typography
                                variant="h3"
                                className="mb-3 font-bold"
                                color="blue-gray"
                            >
                                Our Mission
                            </Typography>
                            <Typography className="mb-8 font-normal text-blue-gray-500">
                                At {site_name}, we’re passionate about helping
                                individuals cultivate the right mindset and
                                habits to achieve success. Whether you're
                                working towards personal growth, productivity,
                                or overcoming challenges, our mission is to
                                guide you to a better, more fulfilling life.
                            </Typography>
                            {/* <Button variant="filled">read more</Button> */}
                        </div>
                        <div className="mx-auto mt-24 flex w-full justify-center px-4 md:w-4/12 lg:mt-0">
                            <Card className="shadow-lg border shadow-gray-500/10 rounded-lg">
                                <CardHeader
                                    floated={false}
                                    className="relative h-56"
                                >
                                    <img
                                        alt="Card Image"
                                        src="/images/motivation.webp"
                                        className="h-full w-full"
                                    />
                                </CardHeader>
                                <CardBody>
                                    <Typography
                                        variant="h5"
                                        color="blue-gray"
                                        className="mb-3 mt-2 font-bold"
                                    >
                                        A Community of Growth
                                    </Typography>
                                    <Typography className="font-normal text-blue-gray-500">
                                        We are more than just a blog; we are a
                                        community of like-minded individuals who
                                        are passionate about personal growth and
                                        transformation. Join us as we explore
                                        topics like mindfulness, productivity,
                                        relationships, and more, and together,
                                        let's create a life that is both
                                        meaningful and fulfilling.
                                    </Typography>
                                </CardBody>
                            </Card>
                        </div>
                    </div>
                </div>
            </section>
            <section className="px-4 pt-20 pb-32">
                <div className="container mx-auto">
                    <PageTitle
                        heading="Inspiration for Daily Growth"
                    >
                        Stay motivated every day with fresh content that
                        encourages continuous self-improvement and personal
                        transformation.
                    </PageTitle>
                    <div className="mt-24 grid grid-cols-1 gap-12 gap-x-24 md:grid-cols-2 xl:grid-cols-4">
                        {posts.map((post) => (
                            <PostCard
                                key={post.title}
                                img={post.featured_image}
                                name={post.title}
                                excerpt={post.excerpt}
                            />
                        ))}
                    </div>
                </div>
            </section>
            <section className="relative bg-white py-24 px-4">
                <div className="container mx-auto">
                    <PageTitle
                        heading="Stay Connected"
                    >
                        Get exclusive motivation tips, updates, and inspirational stories directly to your inbox.
                    </PageTitle>
                    <form className="mx-auto w-full mt-12 lg:w-5/12">
                        <div className="mb-8 flex gap-8">
                            <Input
                                variant="outlined"
                                size="lg"
                                label="Full Name"
                            />
                            <Input
                                variant="outlined"
                                size="lg"
                                label="Email Address"
                            />
                        </div>
                        <Button
                            variant="gradient"
                            size="lg"
                            className="mt-8"
                            fullWidth
                        >
                            Subscribe Now
                        </Button>
                    </form>
                </div>
            </section>
            <div className="bg-white">
                <Footer />
            </div>
        </>
    );
}
