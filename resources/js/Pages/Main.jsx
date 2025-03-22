import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import {InputLabel, PrimaryButton, SelectInput} from "@/Components/index.jsx";
import PropTypes from "prop-types";
import {IdeaSection} from "@/Pages/Sections/IdeaSection.jsx";


export default function Main({ category, level, categories, levels, ideas }) {
    const { data, setData, get, processing} = useForm(
        {
            category: category ?? 'web',
            level: level ?? 'easy',
        }
    );

    const submit = (e) => {
        e.preventDefault();
        get(route('main'), {
            data,
            onError: (errors) => {
                console.log('Errors', errors);
            },
            onSuccess: (resp) => {
                console.log('Response', resp);
            }
        });
    }

    return (
        <>
            <Head title="Pet Project Ideas" />
            <div className="bg-gray-50 text-black/50 dark:bg-gray-700 dark:text-white/50">
                <div className="relative flex min-h-screen flex-col items-center  selection:bg-[#FF2D20] selection:text-white">
                    <div className="relative w-full max-w-2xl px-6 lg:max-w-7xl items-center">
                        <header className="items-center gap-2 py-10">
                            <div className="flex lg:justify-center text-2xl">
                                <img src="/images/logo.png" width="100" />
                            </div>
                        </header>

                        <main className=" max-w-3xl">
                            <div className="flex lg:justify-center">
                                <p className="text-lg text-center">
                                    Pet Project Ideas is a website that helps you discover fresh ideas for your next
                                    pet project.<br/>
                                    The best way to learn something new is by building something yourself!
                                </p>
                            </div>

                            <div className="flex lg:justify-center mt-6">
                                <form onSubmit={submit}>
                                    <div className="flex flex-col lg:flex-row gap-4">
                                        <InputLabel htmlFor="category" value="Category"/>
                                        <SelectInput options={categories} value={category}
                                                     onChange={(e) => setData('category', e.target.value)}/>

                                        <InputLabel htmlFor="level" value="Level"/>
                                        <SelectInput options={levels} value={level}
                                                     onChange={(e) => setData('level', e.target.value)}/>

                                        <PrimaryButton className="ms-4" disabled={processing}>
                                            Generate Ideas
                                        </PrimaryButton>
                                    </div>
                                </form>
                            </div>

                            <div className="mt-6">
                                {!processing && ideas.map((idea, num) => (
                                    <IdeaSection key={`idea-${num}`} title={idea.title} description={idea.description}/>
                                ))}
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

Main.defaultProps = {
    category: 'web',
    level: 'easy',
    categories: [],
    levels: [],
    ideas: [],
}

Main.propTypes = {
    category: PropTypes.string,
    level: PropTypes.string,
    categories: PropTypes.arrayOf(
        PropTypes.shape({
            value: PropTypes.string.isRequired,
            label: PropTypes.string.isRequired,
        })
    ).isRequired,
    levels: PropTypes.arrayOf(
        PropTypes.shape({
            value: PropTypes.string.isRequired,
            label: PropTypes.string.isRequired,
        })
    ).isRequired,
    ideas: PropTypes.arrayOf(
        PropTypes.shape({
            title: PropTypes.string.isRequired,
            description: PropTypes.string.isRequired,
        })
    ).isRequired,
}
