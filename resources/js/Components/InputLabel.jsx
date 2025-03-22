import React from "react";
import PropTypes from "prop-types";

export default function InputLabel({
    value,
    className = '',
    children,
    ...props
}) {
    return (
        <label
            {...props}
            className={
                `block align-middle content-center font-medium text-gray-700 dark:text-gray-300` +
                className
            }
        >
            {value ? value : children}
        </label>
    );
}

InputLabel.defaultProps = {
    value: '',
    className: '',
}

InputLabel.propTypes = {
    value: PropTypes.string,
    className: PropTypes.string,
    children: PropTypes.node,
}
