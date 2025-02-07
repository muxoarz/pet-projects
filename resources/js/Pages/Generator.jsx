import { Head, Link, useForm } from '@inertiajs/react';
import PrimaryButton from "@/Components/PrimaryButton.jsx";

export default function Generator({ auth, laravelVersion, phpVersion }) {
    const { data, setData, post, processing, errors, reset } = useForm();

    return (
        <>
            <Head title="Pet Project Ideas Generator" />
            <div className="bg-gray-50 text-black/50 dark:bg-gray-700 dark:text-white/50">
                <div className="relative flex min-h-screen flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                    <div className="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                        <header className="items-center gap-2 py-10">
                            <div className="flex lg:justify-center text-2xl">
                                Pet Project Ideas Generator
                            </div>
                        </header>

                        <main className="mt-6">

                            <div className="flex lg:justify-center ">
                                <p className="text-lg text-center">
                                    Pet Project Idea Generator is a website that helps you discover fresh ideas for your next pet project.<br/>
                                    The best way to learn something new is by building something yourself!
                                </p>
                            </div>

                            <div className="flex lg:justify-center mt-6">
                                <form>
                                    <div className="flex flex-col lg:flex-row gap-4">

                                        <PrimaryButton className="ms-4" disabled={processing}>
                                            Generate Idea
                                        </PrimaryButton>
                                    </div>
                                </form>
                            </div>

                        </main>

                        <footer className="py-16 text-center text-sm text-black dark:text-white/70">
                            Pet Project created by <a href="">Mikhail Kalekin</a>
                        </footer>
                    </div>
                </div>
            </div>
        </>
    );
}
