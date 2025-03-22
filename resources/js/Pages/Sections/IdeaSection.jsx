import React from "react";
import PropTypes from "prop-types";

export const IdeaSection = ({ title, description }) => {
    return (
        <div className="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg mb-6">
            <div className="px-4 py-5 sm:px-6">
                <h3 className="text-lg font-medium leading-3 text-gray-900 dark:text-white"><a href={""}>{title}</a></h3>
            </div>
            <div className="border-t border-gray-200 dark:border-gray-700">
                <dl>
                    <div className="bg-gray-50 dark:bg-gray-800 px-6 mb-3">
                        <dd className="mt-1 text-sm text-gray-900 dark:text-white">{description}</dd>
                    </div>
                </dl>
            </div>
        </div>
    );
}

IdeaSection.defaultProps = {
    title: '',
    description: '',
}

IdeaSection.propTypes = {
    title: PropTypes.string,
    description: PropTypes.string,
}
