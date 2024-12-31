import { Head, Link } from "@inertiajs/react";
import { Footer, Navbar } from "@/widgets/layout";
import React from "react";
import "../../css/tailwind.min.css";
import { Typography } from "@material-tailwind/react";

export default function Blog(data) {
    return (
        <>
            <Head title="Blog" />
            <div className="container absolute left-2/4 z-10 mx-auto -translate-x-2/4 p-4">
                <Navbar className="text-black" />
            </div>
            <div className="relative flex h-screen content-center items-center justify-center pt-16 pb-32">
                <section className="bg-white dark:bg-gray-900">
                    <div className="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
                        <div className="grid gap-8 lg:grid-cols-4">
                            <article className="p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                                <img
                                    className="mb-5 rounded-lg"
                                    src="https://images.unsplash.com/photo-1614278016630-017112643d7f?q=80&w=2080&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                    alt="office content 1"
                                />
                                <Typography
                                    variant="h5"
                                    color="blue-gray"
                                    className="mt-6 mb-1"
                                >
                                    10 Proven Strategies to Overcome
                                    Procrastination
                                </Typography>
                                <p className="font-normal text-blue-gray-500 mt-6 mb-1">
                                    Struggling with procrastination? Here are 10
                                    proven strategies to boost productivity.
                                </p>
                                <Link
                                    href="#"
                                    className="mt-6 ml-auto mr-auto w-full block text-center p-1 btn hover:bg-gray-900 hover:text-white bg-white text-gray-900 border border-gray-900 rounded group"
                                >
                                    Read More
                                    <span className="ml-2 transform transition-transform duration-300 group-hover:translate-x-2 hidden group-hover:inline-block">
                                        →
                                    </span>
                                </Link>
                            </article>
                        </div>
                    </div>
                </section>
            </div>
            <div className="bg-white">
                <Footer />
            </div>
        </>
    );
}
