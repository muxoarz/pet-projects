import React from 'react';
import PropTypes from "prop-types";

export default function SelectInput({ id, name, value, options = [], onChange, ...props }) {
    console.log('SelectInput', value, options);
    options.map((option) => console.log(option.value === value));
    return (
        <select
            id={id}
            name={name}
            onChange={onChange}
            className="block w-full mt-1 h-fit border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600  rounded-md"
            {...props}
        >
            {options.map((option) => (
                <option key={option.value} value={option.value} selected={option.value === value} data={option.value === value}>
                    {option.label}
                </option>
            ))}
        </select>
    );
}

SelectInput.defaultProps = {
    options: [],
    value: '',
    onChange: () => {},
}

SelectInput.propTypes = {
    id: PropTypes.string.isRequired,
    name: PropTypes.string.isRequired,
    value: PropTypes.string,
    options: PropTypes.arrayOf(
        PropTypes.shape({
            value: PropTypes.string.isRequired,
            label: PropTypes.string.isRequired,
        })
    ).isRequired,
    onChange: PropTypes.func,
}
